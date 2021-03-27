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
    public function index(Request $request)
    {
        abort_if(Gate::denies('dashboard'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $where                                = [];
        $where['active_opportunities.status'] = ActiveOpportunity::STATUS_ON_PROGRESS;

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

        $query = $query->get();

        if ($request->ajax()) {
            return view('datatable-home', compact('query'));
        }

        return view('home', compact('query'));
    }

}

