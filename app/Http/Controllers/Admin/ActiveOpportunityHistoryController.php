<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActiveOpportunity;
use App\Repositories\ActiveOpportunityHistoryRepository;
use App\Repositories\ActiveOpportunityReminderRepository;
use App\Repositories\ActiveOpportunityRepository;
use App\Repositories\UserRepository;
use Exception;
use Gate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

/**
 * Class ActiveOpportunityController
 * @package App\Http\Controllers\Admin
 */
class ActiveOpportunityHistoryController extends Controller
{
    /**
     * @var ActiveOpportunityRepository
     */
    public $activeOpportunityHistoryRepository, $user;

    /**
     * ActiveOpportunityController constructor.
     * @param ActiveOpportunityHistoryRepository $activeOpportunityHistoryRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        ActiveOpportunityHistoryRepository $activeOpportunityHistoryRepository,
        UserRepository $userRepository
    ) {
        $this->activeOpportunityHistoryRepository = $activeOpportunityHistoryRepository;
        $this->user                               = $userRepository;
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request, $id)
    {
        abort_if(Gate::denies('active_opportunity_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = $this->activeOpportunityHistoryRepository->allQuery(['active_opportunity_id' => $id],
            ['activeOpportunityData', 'userData', 'activeOpportunityData.activeClientData', 'createdByData']);

        $table = Datatables::of($query);
        $table->addColumn('placeholder', ' ');
        $table->addColumn('actions', '&nbsp;');

        $table->editColumn('active_client_id', function ($row) {
            return $row->activeOpportunityData->activeClientData->name ?? '';
        });

        $table->editColumn('created_by', function ($row) {
            return $row->createdByData->name ?? '';
        });

        $table->editColumn('act_history', function ($row) {
            return $row->act_history !=
                   \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER ? (new ActiveOpportunity)->getActHistory($row->act_history) : $row->act_history_other_name;
        });

        if (me()->id == 1) {
            $table->editColumn('actions', function ($row) {
                $viewGate      = 'no_direct';
                $editGate      = 'active_opportunity_edit';
                $deleteGate    = 'active_opportunity_delete';
                $crudRoutePart = 'active-opportunity-history';
                return view('partials.datatablesActionsModals', compact(
                        'viewGate',
                        'editGate',
                        'deleteGate',
                        'crudRoutePart',
                        'row'
                    )
                );
            }
            );
        }

        return $table->make(true);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        abort_if(Gate::denies('active_opportunity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activeOpportunity = $this->activeOpportunityHistoryRepository->findData(['id' => $id]);

        return view('admin.active-opportunity.edit', compact('activeOpportunity'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View
     */
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('active_opportunity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->activeOpportunityHistoryRepository->updateData($request->except('_token', '_method'), ['id' => $id]);

        return back();
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
            $this->activeOpportunityHistoryRepository->deleteData(['id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
        }

        DB::commit();

        return back();
    }
}
