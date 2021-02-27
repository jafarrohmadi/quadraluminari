<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyActiveClientRequest;
use App\Http\Requests\StoreActiveClientRequest;
use App\Http\Requests\UpdateActiveClientRequest;
use App\Models\ActiveClient;
use App\Repositories\ActiveClientRepository;
use App\Repositories\CityRepository;
use App\Repositories\ProvinceRepository;
use Gate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class  ActiveClientController extends Controller
{
    /**
     * @var ActiveClientRepository
     */
    protected $activeClient, $province, $city;

    /**
     * ActiveClientController constructor.
     * @param ActiveClientRepository $activeClient
     * @param ProvinceRepository $provinceRepository
     * @param CityRepository $cityRepository
     */
    public function __construct(
        ActiveClientRepository $activeClient, ProvinceRepository $provinceRepository, CityRepository $cityRepository
    ) {
        $this->activeClient = $activeClient;
        $this->province     = $provinceRepository;
        $this->city         = $cityRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('active_client_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = $this->activeClient->allQuery([], ['addressCityData']);

            $table = Datatables::of($query);
            $table->addColumn('placeholder', ' ');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('status', function ($row) {
                return (new ActiveClient)->getStatus($row->status);
            });

            $table->editColumn('address_city_id', function ($row) {
                return $row->addressCityData->name ?? '';
            });


            $table->editColumn('actions', function ($row) {
                $viewGate      = 'active_client_view';
                $editGate      = 'active_client_edit';
                $deleteGate    = 'active_client_delete';
                $crudRoutePart = 'active-client';
                return view('partials.datatablesActions', compact(
                        'viewGate',
                        'editGate',
                        'deleteGate',
                        'crudRoutePart',
                        'row'
                    )
                );
            }
            );

            return $table->make(true);
        }

        return view('admin.active-client.index');

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
        $this->activeClient->createData($storeActiveClientRequest->all());

        return redirect()->route('admin.active-client.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function show($id)
    {
        $activeClient = $this->activeClient->findData(['id' => $id]);

        return view('admin.active-client.show', compact('activeClient'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function edit($id)
    {
        $activeClient = $this->activeClient->findData(['id' => $id]);

        $province = $this->province->findAllData();
        $cityContactPerson = $this->city->findAllData(['province_id' => $activeClient->contact_person_province_id]);
        $cityAddress = $this->city->findAllData(['province_id' => $activeClient->address_province_id]);

        return view('admin.active-client.edit', compact('activeClient', 'province', 'cityContactPerson' , 'cityAddress'));
    }

    /**
     * @param UpdateActiveClientRequest $updateActiveClientRequest
     * @param $id
     */
    public function update(UpdateActiveClientRequest $updateActiveClientRequest, $id)
    {
        $this->activeClient->updateData($updateActiveClientRequest->except('_method', '_token'), ['id' => $id]);

        return redirect()->route('admin.active-client.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('user_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->activeClient->deleteData(['id' => $id]);

        return back();
    }

    /**
     * @param MassDestroyActiveClientRequest $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function massDestroy(MassDestroyActiveClientRequest $request)
    {
        ActiveClient::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
