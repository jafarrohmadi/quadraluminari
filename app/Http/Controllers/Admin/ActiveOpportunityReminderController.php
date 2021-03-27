<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyActiveClientRequest;
use App\Models\ActiveClient;
use App\Models\ActiveOpportunity;
use App\Repositories\ActiveOpportunityHistoryRepository;
use App\Repositories\ActiveOpportunityReminderRepository;
use App\Repositories\ActiveOpportunityRepository;
use App\Repositories\ProjectDetailHistoryRepository;
use App\Repositories\ProjectDetailRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use Gate;

/**
 * Class ActiveOpportunityController
 * @package App\Http\Controllers\Admin
 */
class ActiveOpportunityReminderController extends Controller
{
    /**
     * @var ActiveOpportunityRepository
     */
    public $activeOpportunityRepository, $activeOpportunityHistoryRepository, $activeOpportunityReminderRepository, $user, $projectDetailRepository, $projectDetailHistoryRepository;

    /**
     * ActiveOpportunityController constructor.
     * @param ActiveOpportunityRepository $activeOpportunityRepository
     * @param ActiveOpportunityHistoryRepository $activeOpportunityHistoryRepository
     * @param ActiveOpportunityReminderRepository $activeOpportunityReminderRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        ActiveOpportunityRepository $activeOpportunityRepository,
        ActiveOpportunityHistoryRepository $activeOpportunityHistoryRepository,
        ActiveOpportunityReminderRepository $activeOpportunityReminderRepository,
        UserRepository $userRepository,
        ProjectDetailRepository $projectDetailRepository, ProjectDetailHistoryRepository $projectDetailHistoryRepository
    ) {
        $this->activeOpportunityRepository         = $activeOpportunityRepository;
        $this->activeOpportunityHistoryRepository  = $activeOpportunityHistoryRepository;
        $this->activeOpportunityReminderRepository = $activeOpportunityReminderRepository;
        $this->user                                = $userRepository;
        $this->projectDetailRepository             = $projectDetailRepository;
        $this->projectDetailHistoryRepository      = $projectDetailHistoryRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('active_opportunity_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (me()->id == 1) {
            $query = $this->activeOpportunityRepository->allQuery(['reminder' => 1,],
                ['activeClientData', 'userData']);
        }
        else {
            $query = $this->activeOpportunityRepository->allQuery(['user_id' => me()->id, 'reminder' => 1],
                ['activeClientData', 'userData']);
        }

        $query = $query->join('active_opportunity_reminders', 'active_opportunities.id',
            'active_opportunity_reminders.active_opportunity_id')
            ->where('active_opportunity_reminders.id', function ($query) {
                $query->select('id')
                    ->from('active_opportunity_reminders')
                    ->whereColumn('active_opportunity_id', 'active_opportunities.id')
                    ->latest()
                    ->limit(1);
            })->where('active_opportunity_reminders.act_history_date_reminder', '>=', date('Y-m-d'))
            ->select('active_opportunities.*',
                'active_opportunity_reminders.act_history_date_reminder',
                'active_opportunity_reminders.act_history_order_reminder')->get();

        return view('admin.active-opportunity-reminder.index', compact('query'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        abort_if(Gate::denies('active_opportunity_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user              = $this->user->findAllData([['id', '!=', 1]]);
        $activeOpportunity = $this->activeOpportunityRepository->findData(['id' => $id],
            ['userData', 'activeClientData', 'activeOpportunityHistoryData', 'activeOpportunityHistoryReminderData']);

        return view('admin.active-opportunity-reminder.show', compact('user', 'activeOpportunity'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        abort_if(Gate::denies('active_opportunity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user              = $this->user->findAllData([['id', '!=', 1]]);
        $activeOpportunity = $this->activeOpportunityRepository->findData(['id' => $id],
            [
                'userData', 'activeClientData', 'activeOpportunityHistoryData', 'activeOpportunityHistoryReminderData',
                'projectDetailData',
            ]);

        return view('admin.active-opportunity-reminder.edit', compact('user', 'activeOpportunity'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $input = $request->except('_method', '_token', 'act_history_reminder', 'act_history_date_reminder',
                'act_history_other_name_reminder', 'act_history_order_reminder', 'act_history_notes_reminder',
                'detail_id', 'detail_name', 'detail_qty', 'detail_value', 'detail_notes');

            $opportunity = $this->activeOpportunityRepository->updateData($input, ['id' => $id]);

            if ($request->act_history_date != $opportunity->activeOpportunityHistoryData->first()->act_history_date ||
                $request->opportunity_status !=
                $opportunity->activeOpportunityHistoryData->first()->opportunity_status ||
                $request->act_history_remarks !=
                $opportunity->activeOpportunityHistoryData->first()->act_history_remarks
                || $request->user_id != $opportunity->activeOpportunityHistoryData->first()->user_id ||
                $request->act_history != $opportunity->activeOpportunityHistoryData->first()->act_history ||
                $request->act_history_other_name !=
                $opportunity->activeOpportunityHistoryData->first()->act_history_other_name ||
                $request->opportunity_status_remarks !=
                $opportunity->activeOpportunityHistoryData->first()->opportunity_status_remarks
                || $request->status != $opportunity->activeOpportunityHistoryData->first()->status

            ) {
                $input                          = $request->all();
                $input['active_opportunity_id'] = $id;
                $this->activeOpportunityHistoryRepository->createData($input);
            }

            if ($request->act_history_reminder !=
                $opportunity->activeOpportunityHistoryReminderData->first()->act_history_reminder ||
                $request->act_history_other_name_reminder !=
                $opportunity->activeOpportunityHistoryReminderData->first()->act_history_other_name_reminder ||
                $request->act_history_order_reminder !=
                $opportunity->activeOpportunityHistoryReminderData->first()->act_history_order_reminder ||
                $request->act_history_date_reminder !=
                $opportunity->activeOpportunityHistoryReminderData->first()->act_history_date_reminder ||
                $request->act_history_notes_reminder !=
                $opportunity->activeOpportunityHistoryReminderData->first()->act_history_notes_reminder) {

                $input                          = $request->all();
                $input['active_opportunity_id'] = $id;
                $this->activeOpportunityReminderRepository->createData($input);
            }

            foreach ($request->detail_name as $key => $value) {
                $detailProject = $opportunity->projectDetailData->where('id', $request->detail_id[$key])->first();
                if ($request->detail_qty[$key] != $detailProject->detail_qty ||
                    $request->detail_notes[$key] != $detailProject->detail_notes ||
                    $request->detail_value[$key] != $detailProject->detail_value ||
                    $value != $detailProject->detail_name
                ) {
                    $data['active_opportunity_id'] = $opportunity->id;
                    $data['detail_name']           = $value;
                    $data['detail_qty']            = $request->detail_qty[$key];
                    $data['detail_notes']          = $request->detail_notes[$key];
                    $data['detail_value']          = $request->detail_value[$key];

                    $detail                    = $this->projectDetailRepository->updateData($data,
                        ['id' => $request->detail_id[$key]]);
                    $data['project_detail_id'] = $detail->id;
                    $this->projectDetailHistoryRepository->createData($data);
                }
            }

        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();

        return redirect()->route('admin.active-opportunity-reminder.index');

    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('active_opportunity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::beginTransaction();

        try {
            $this->activeOpportunityRepository->deleteData(['id' => $id]);
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
            ActiveOpportunity::whereIn('id', request('ids'))->delete();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        DB::commit();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
