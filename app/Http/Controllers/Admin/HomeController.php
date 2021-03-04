<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActiveClient;
use App\Repositories\ActiveClientRepository;
use App\Repositories\CityRepository;
use App\Repositories\ProvinceRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use Gate;
class HomeController
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

    public function index(Request  $request)
    {
        abort_if(Gate::denies('dashboard'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

            $table->editColumn('contact_person_mobile_email', function ($row) {
                $data = [];
                if (isset($row->contact_person_mobile_email)) {
                    $explode = explode(";",$row->contact_person_mobile_email);

                    foreach ( $explode as $email) {
                        $data [] = sprintf('<span class="badge badge-info">%s</span>', $email);
                    }
                }

                return $data ? implode(" ", $data) : '';
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

            $table->rawColumns(['actions', 'placeholder', 'contact_person_mobile_email']);

            return $table->make(true);
        }
        return view('home');
    }
}
