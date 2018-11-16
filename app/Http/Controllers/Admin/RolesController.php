<?php

namespace App\Http\Controllers\Admin;

use App\Handlers\Tree;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use App\Repositories\RulesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesController extends BaseController
{
    /**
     * 展示所有角色
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Role $role)
    {
        $roles = $role->thisUser()->paginate(20);

        return $this->view(null,compact('roles'));
    }

    /**
     * 展示角色页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data = Auth::id();
        return $this->view()->with('data',$data);
    }

    /**
     * 添加角色
     * @param RoleRequest $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request, Role $role)
    {
        $role->fill($request->only("u_id","name","remark","status",'order'));

        if ($role->save()){
            flash('添加角色成功')->success()->important();
        }else{
            flash('添加角色失败')->success()->important();
        }

        return redirect()->route('roles.index');
    }


    /**
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        return $this->view('edit',compact('role'));
    }

    /**
     * @param RoleRequest $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->all());

        flash('修改成功')->success()->important();

        return redirect()->route('roles.index');
    }

    /**
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        $role->rules()->detach(); //删除关联数据

        $role->delete();

        flash('删除成功')->success()->important();

        return redirect()->route('roles.index');
    }

    /**
     * 展示分配权限页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function access(Role $role,RulesRepository $rulesRepository,Tree $tree)
    {

        $rules = $rulesRepository->getRules();
        if (Auth::id() != 1)
        {
            $rules = Auth::user()->thisRoleMenu();
        }
//        dd(Auth::user()->thisRoleMenu(),$rules);

        $datas = $tree::channelLevel( $rules, 0, '&nbsp;', 'id','parent_id');

        $rules = $role->rules->pluck('id')->toArray();

        return $this->view(null,compact('role','datas','rules'));
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function groupAccess(Request $request,Role $role)
    {

        $role->rules()->sync($request->get('rule_id'));

        flash('授权成功')->success()->important();

        return redirect()->route('roles.index');
    }
}
