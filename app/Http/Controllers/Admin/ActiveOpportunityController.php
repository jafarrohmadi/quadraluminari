<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyActiveClientRequest;
use App\Models\ActiveClient;
use App\Models\ActiveOpportunity;
use App\Repositories\ActiveOpportunityHistoryRepository;
use App\Repositories\ActiveOpportunityReminderRepository;
use App\Repositories\ActiveOpportunityRepository;
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
    public $activeOpportunityRepository, $activeOpportunityHistoryRepository, $activeOpportunityReminderRepository, $user;

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
        UserRepository $userRepository
    ) {
        $this->activeOpportunityRepository         = $activeOpportunityRepository;
        $this->activeOpportunityHistoryRepository  = $activeOpportunityHistoryRepository;
        $this->activeOpportunityReminderRepository = $activeOpportunityReminderRepository;
        $this->user                                = $userRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('active_opportunity_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = $this->activeOpportunityRepository->allQuery([], ['activeClientData', 'userData']);

            $table = Datatables::of($query);
            $table->addColumn('placeholder', ' ');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('active_client_id', function ($row) {
                return $row->activeClientData->name ?? '';
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

        return view('admin.active-opportunity.index');
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
    public function edit($id)
    {
        abort_if(Gate::denies('active_opportunity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user              = $this->user->findAllData([['id', '!=', 1]]);
        $activeOpportunity = $this->activeOpportunityRepository->findData(['id' => $id],
            ['userData', 'activeClientData', 'activeOpportunityHistoryData', 'activeOpportunityHistoryReminderData']);

        return view('admin.active-opportunity.edit', compact('user', 'activeOpportunity'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $input       = $request->all();
            $opportunity = $this->activeOpportunityRepository->updateData($input, ['id' => $id]);

            $input['active_opportunity_id'] = $id;

            $this->activeOpportunityHistoryRepository->createData($input);

            $this->activeOpportunityReminderRepository->createData($input);
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
