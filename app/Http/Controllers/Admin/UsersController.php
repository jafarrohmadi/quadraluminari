<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Permission;
use App\Models\User;
use App\Repositories\PermissionRepository;
use App\Repositories\UserRepository;
use Gate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
     * @var
     */
    protected $user, $permission;

    /**
     * UsersController constructor.
     * @param UserRepository $userRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(UserRepository $userRepository, PermissionRepository $permissionRepository)
    {
        $this->user = $userRepository;
        $this->permission = $permissionRepository;
    }


    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        abort_if(Gate::denies('user_management_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = $this->user->findAllData([['id' ,'!=' , 1]]);

        return view('admin.users.index', compact('users'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        abort_if(Gate::denies('user_management_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission = $this->permission->findAllData();

        return view('admin.users.create', compact('permission'));
    }

    /**
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->user->createData($request->all());
        $user->permission()->sync($request->input('permissions', []));

        return redirect()->route('admin.users.index');
    }

    /**
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        abort_if(Gate::denies('user_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission = $this->permission->findAllData();

        $user->load('permission');

        return view('admin.users.edit', compact('permission', 'user'));
    }

    /**
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->permission()->sync($request->input('permissions', []));

        return redirect()->route('admin.users.index');
    }

    /**
     * @param User $user
     * @return Application|Factory|View
     */
    public function show(User $user)
    {
        abort_if(Gate::denies('user_management_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('permission');

        return view('admin.users.show', compact('user'));
    }

    /**
     * @param User $user
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    /**
     * @param MassDestroyUserRequest $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
