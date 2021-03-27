<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyActiveClientRequest;
use App\Models\ActiveClient;
use App\Models\ActiveOpportunity;
use App\Models\ProjectDetail;
use App\Models\ProjectDetailHistory;
use App\Repositories\ActiveClientRepository;
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
class ActiveOpportunityController extends Controller
{
    /**
     * @var ActiveOpportunityRepository
     */
    public $activeOpportunityRepository, $activeOpportunityHistoryRepository, $activeOpportunityReminderRepository, $user, $activeClientRepository,
        $projectDetailRepository, $projectDetailHistoryRepository;

    /**
     * ActiveOpportunityController constructor.
     * @param ActiveOpportunityRepository $activeOpportunityRepository
     * @param ActiveOpportunityHistoryRepository $activeOpportunityHistoryRepository
     * @param ActiveOpportunityReminderRepository $activeOpportunityReminderRepository
     * @param UserRepository $userRepository
     * @param ActiveClientRepository $activeClientRepository
     * @param ProjectDetail $projectDetail
     * @param ProjectDetailHistory $projectDetailHistory
     */
    public function __construct(
        ActiveOpportunityRepository $activeOpportunityRepository,
        ActiveOpportunityHistoryRepository $activeOpportunityHistoryRepository,
        ActiveOpportunityReminderRepository $activeOpportunityReminderRepository,
        UserRepository $userRepository, ActiveClientRepository $activeClientRepository,
        ProjectDetailRepository $projectDetailRepository, ProjectDetailHistoryRepository $projectDetailHistoryRepository
    ) {
        $this->activeOpportunityRepository         = $activeOpportunityRepository;
        $this->activeOpportunityHistoryRepository  = $activeOpportunityHistoryRepository;
        $this->activeOpportunityReminderRepository = $activeOpportunityReminderRepository;
        $this->user                                = $userRepository;
        $this->activeClientRepository              = $activeClientRepository;
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
            $query = $this->activeOpportunityRepository->findAllData([], ['activeClientData', 'userData']);
        }
        else {
            $query = $this->activeOpportunityRepository->findAllData(['user_id' => me()->id],
                ['activeClientData', 'userData']);
        }

        return view('admin.active-opportunity.index', compact('query'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        abort_if(Gate::denies('active_opportunity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = $this->user->findAllData([['id', '!=', 1]]);
        return view('admin.active-opportunity.create', compact('user'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $input       = $request->all();
            $opportunity = $this->activeOpportunityRepository->createData($input);

            $input['active_opportunity_id'] = $opportunity->id;
            $this->activeOpportunityHistoryRepository->createData($input);

            $this->activeOpportunityReminderRepository->createData($input);

            $this->activeClientRepository->updateData(['status' => ActiveClient::Status_Active],
                ['id' => $request->active_client_id]);

            foreach ($request->detail_name as $key => $value) {
                $data['active_opportunity_id'] = $opportunity->id;
                $data['detail_name']           = $value;
                $data['detail_qty']            = $request->detail_qty[$key];
                $data['detail_notes']          = $request->detail_notes[$key];
                $data['detail_value']          = $request->detail_value[$key];

                if ($request->detail_qty[$key] ||
                    $request->detail_notes[$key] || $value) {
                    $detail                    = $this->projectDetailRepository->createData($data);
                    $data['project_detail_id'] = $detail->id;
                    $this->projectDetailHistoryRepository->createData($data);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();

        return redirect()->route('admin.active-opportunity.index');

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

        return view('admin.active-opportunity.show', compact('user', 'activeOpportunity'));
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

        return view('admin.active-opportunity.edit', compact('user', 'activeOpportunity'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
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

        return redirect()->route('admin.active-opportunity.index');

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
