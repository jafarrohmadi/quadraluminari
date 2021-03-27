<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyActiveClientRequest;
use App\Http\Requests\StoreActiveClientRequest;
use App\Http\Requests\UpdateActiveClientRequest;
use App\Imports\ActiveClientImport;
use App\Models\ActiveClient;
use App\Repositories\ActiveClientRepository;
use App\Repositories\CityRepository;
use App\Repositories\ContactPersonRepository;
use App\Repositories\ProvinceRepository;
use Gate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class  ActiveClientController extends Controller
{
    /**
     * @var ActiveClientRepository
     */
    protected $activeClient, $province, $city, $contactPersonRepository;

    /**
     * ActiveClientController constructor.
     * @param ActiveClientRepository $activeClient
     * @param ProvinceRepository $provinceRepository
     * @param CityRepository $cityRepository
     * @param ContactPersonRepository $contactPersonRepository
     */
    public function __construct(
        ActiveClientRepository $activeClient, ProvinceRepository $provinceRepository, CityRepository $cityRepository,
        ContactPersonRepository $contactPersonRepository
    ) {
        $this->activeClient            = $activeClient;
        $this->province                = $provinceRepository;
        $this->city                    = $cityRepository;
        $this->contactPersonRepository = $contactPersonRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('active_client_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = $this->activeClient->findAllData([], ['addressCityData']);

        return view('admin.active-client.index', compact('query'));

    }

    /**
     * @return Application|Factory|\Illuminate\View\View
     */
    public function create()
    {
        $province = $this->province->findAllData();

        return view('admin.active-client.create', compact('province'));
    }

    /**
     * @param StoreActiveClientRequest $storeActiveClientRequest
     * @return RedirectResponse
     */
    public function store(StoreActiveClientRequest $storeActiveClientRequest)
    {
        DB::beginTransaction();

        try {
            $active = $this->activeClient->createData($storeActiveClientRequest->all());
            foreach ($storeActiveClientRequest->contact_person_name as $key => $value) {
                $data['active_client_id']            = $active->id;
                $data['contact_person_name']         = $value;
                $data['contact_person_grade']        = $storeActiveClientRequest->contact_person_grade[$key];
                $data['contact_person_phone']        = $storeActiveClientRequest->contact_person_phone[$key];
                $data['contact_person_mobile_phone'] = $storeActiveClientRequest->contact_person_mobile_phone[$key];
                $data['contact_person_mobile_email'] = $storeActiveClientRequest->contact_person_mobile_email[$key];

                if ($storeActiveClientRequest->contact_person_grade[$key] ||
                    $storeActiveClientRequest->contact_person_phone[$key] ||
                    $storeActiveClientRequest->contact_person_mobile_phone[$key]
                    || $storeActiveClientRequest->contact_person_mobile_email[$key] || $value) {
                    $this->contactPersonRepository->createData($data);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

        DB::commit();

        return redirect()->route('admin.active-client.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function show($id)
    {
        $activeClient = $this->activeClient->findData(['id' => $id], ['contactPersonData']);

        return view('admin.active-client.show', compact('activeClient'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function edit($id)
    {
        $activeClient = $this->activeClient->findData(['id' => $id], ['contactPersonData']);

        $province          = $this->province->findAllData();
        $cityContactPerson = $this->city->findAllData(['province_id' => $activeClient->contact_person_province_id]);
        $cityAddress       = $this->city->findAllData(['province_id' => $activeClient->address_province_id]);

        return view('admin.active-client.edit',
            compact('activeClient', 'province', 'cityContactPerson', 'cityAddress'));
    }

    /**
     * @param UpdateActiveClientRequest $updateActiveClientRequest
     * @param $id
     */
    public function update(UpdateActiveClientRequest $updateActiveClientRequest, $id)
    {
        DB::beginTransaction();

        try {
            $active = $this->activeClient->updateData($updateActiveClientRequest->except('_method', '_token', 'active_client_id', 'contact_person_name', 'contact_person_phone',
            'contact_person_mobile_phone', 'contact_person_mobile_email', 'contact_person_grade'),
                ['id' => $id]);
            $this->contactPersonRepository->deleteData(['active_client_id' => $active->id]);

            foreach ($updateActiveClientRequest->contact_person_name as $key => $value) {
                $data['active_client_id']            = $active->id;
                $data['contact_person_name']         = $value;
                $data['contact_person_grade']        = $updateActiveClientRequest->contact_person_grade[$key];
                $data['contact_person_phone']        = $updateActiveClientRequest->contact_person_phone[$key];
                $data['contact_person_mobile_phone'] = $updateActiveClientRequest->contact_person_mobile_phone[$key];
                $data['contact_person_mobile_email'] = $updateActiveClientRequest->contact_person_mobile_email[$key];

                if ($updateActiveClientRequest->contact_person_grade[$key] ||
                    $updateActiveClientRequest->contact_person_phone[$key] ||
                    $updateActiveClientRequest->contact_person_mobile_phone[$key]
                    || $updateActiveClientRequest->contact_person_mobile_email[$key] || $value) {
                    $this->contactPersonRepository->createData($data);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

        DB::commit();

        return redirect()->route('admin.active-client.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('user_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::beginTransaction();

        try {
            $this->activeClient->deleteData(['id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
        }

        DB::commit();

        return back();
    }

    /**
     * @param MassDestroyActiveClientRequest $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function massDestroy(MassDestroyActiveClientRequest $request)
    {
        DB::beginTransaction();

        try {
            ActiveClient::whereIn('id', request('ids'))->delete();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        DB::commit();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function import()
    {
        Excel::import(new ActiveClientImport, public_path('excel.xlsx'));

        return redirect('/')->with('success', 'All good!');
    }
}
