<?php

namespace App\Http\Controllers\Admin;

use App\Mail\ReminderEmail;
use App\Models\ActiveClient;
use App\Models\ActiveOpportunity;
use App\Models\ActiveOpportunityReminder;
use App\Repositories\ActiveClientRepository;
use App\Repositories\ActiveOpportunityReminderRepository;
use App\Repositories\ActiveOpportunityRepository;
use App\Repositories\CityRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\UserRepository;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use Gate;

class HomeController
{
    /**
     * @var ActiveClientRepository
     */
    protected $activeOpportunityRepository, $province, $city, $user, $activeOpportunityReminderRepository;

    /**
     * ActiveClientController constructor.
     * @param ActiveOpportunityRepository $activeOpportunityRepository
     * @param ProvinceRepository $provinceRepository
     * @param CityRepository $cityRepository
     * @param UserRepository $userRepository
     * @param ActiveOpportunityReminderRepository $activeOpportunityReminderRepository
     */
    public function __construct(
        ActiveOpportunityRepository $activeOpportunityRepository, ProvinceRepository $provinceRepository,
        CityRepository $cityRepository, UserRepository $userRepository,
        ActiveOpportunityReminderRepository $activeOpportunityReminderRepository
    ) {
        $this->activeOpportunityRepository         = $activeOpportunityRepository;
        $this->province                            = $provinceRepository;
        $this->city                                = $cityRepository;
        $this->user                                = $userRepository;
        $this->activeOpportunityReminderRepository = $activeOpportunityReminderRepository;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        abort_if(Gate::denies('dashboard'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('home');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function dataTable(Request $request)
    {
        $where           = [];
        $where['status'] = ActiveOpportunity::STATUS_ON_PROGRESS;

        if ($request->date_start != null) {
            $where[] = ['act_history_date', '>=', $request->date_start];
        }

        if ($request->date_end != null) {
            $where[] = ['act_history_date', '<=', $request->date_end];
        }

        if ($request->opportunity_status != null) {
            $where['opportunity_status'] = $request->opportunity_status;
        }

        if (me()->id == 1) {
            $query = $this->activeOpportunityRepository->allQuery($where, [
                'activeClientData', 'userData', 'activeClientData.addressCityData',
                'activeOpportunityHistoryReminderData',
            ]);
        }
        else {
            $where['user_id'] = me()->id;

            $query = $this->activeOpportunityRepository->allQuery($where,
                [
                    'activeClientData', 'userData', 'activeClientData.addressCityData',
                    'activeOpportunityHistoryReminderData',
                ]);
        }

        $table = Datatables::of($query);
        $table->addColumn('placeholder', ' ');
        $table->addColumn('actions', '&nbsp;');

        $table->editColumn('active_client_id', function ($row) {
            return $row->activeClientData->name ?? '';
        });

        $table->editColumn('mailing_address', function ($row) {
            return $row->activeClientData->address_mailing_address ?? '';
        });

        $table->editColumn('city_id', function ($row) {
            return $row->activeClientData->addressCityData->name ?? '';
        });

        $table->editColumn('postal_code', function ($row) {
            return $row->activeClientData->address_postal_code ?? '';
        });

        $table->editColumn('contact_person_name', function ($row) {
            return $row->activeClientData->contact_person_name ?? '';
        });

        $table->editColumn('contact_person_grade', function ($row) {
            return $row->activeClientData->contact_person_name ?? '';
        });

        $table->editColumn('phone', function ($row) {
            return $row->activeClientData->contact_person_phone ?? '';
        });

        $table->editColumn('mobile_phone', function ($row) {
            return $row->activeClientData->contact_person_mobile_phone ?? '';
        });

        $table->editColumn('email', function ($row) {
            return $row->activeClientData->contact_person_mobile_email ?? '';
        });

        $table->editColumn('user_id', function ($row) {
            return $row->userData->name ?? '';
        });

        $table->editColumn('act_history', function ($row) {
            return $row->act_history !=
                   \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER ? (new ActiveOpportunity)->getActHistory($row->act_history) : $row->act_history_other_name;
        });

        $table->editColumn('value', function ($row) {
            return (new ActiveOpportunity)->getCurrency($row->value_currency) . ' ' .
                   number_format($row->value, 2, ',', '.');
        });

        $table->editColumn('reminder', function ($row) {
            return $row->reminder == 1 ? 'Ya' : 'Tidak';
        });

        $table->editColumn('act_history_reminder', function ($row) {
            return $row->activeOpportunityHistoryReminderData->last()->act_history_reminder !=
                   \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER ? (new ActiveOpportunity)->getActHistory($row->activeOpportunityHistoryReminderData->last()->act_history_reminder) : $row->activeOpportunityHistoryReminderData->last()->act_history_other_name_reminder;
        });

        $table->editColumn('act_history_date_reminder', function ($row) {
            return $row->activeOpportunityHistoryReminderData->last()->act_history_date_reminder ?? '';
        });
        $table->editColumn('act_history_order_reminder', function ($row) {
            return $row->activeOpportunityHistoryReminderData->last()->act_history_order_reminder ?? '';
        });

        $table->editColumn('act_history_notes_reminder', function ($row) {
            return $row->activeOpportunityHistoryReminderData->last()->act_history_notes_reminder ?? '';
        });


        $table->editColumn('actions', function ($row) {
            $viewGate      = 'active_opportunity_view';
            $editGate      = 'active_opportunity_edit';
            $deleteGate    = 'active_opportunity_delete';
            $crudRoutePart = 'active-opportunity';
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

//    public function reminder()
//    {
//        $user = $this->user->findAllData([['id', '!=', 1]]);
//
//        foreach ($user as $users) {
//            $data = $this->activeOpportunityReminderRepository->findAllData([
//                'user_id'                   => $users->id,
//                'act_history_date_reminder' => date('Y-m-d'),
//            ], ['activeOpportunityData', 'activeOpportunityData.activeClientData']);
//
//            $email = explode(';', $users->email);
//
//            foreach ($email as $emails) {
//                Mail::to($emails)->send(new ReminderEmail($data, $users->name));
//            }
//
//        }
//    }
}

