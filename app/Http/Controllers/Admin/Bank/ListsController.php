<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/6
 * Time: 14:42
 */

namespace App\Http\Controllers\Admin\Bank;


use App\Http\Controllers\Admin\BaseController;
use App\Services\ActionLogsService;
use Illuminate\Support\Facades\Auth;

class ListsController extends BaseController
{
    protected $actionLogsService;
    protected $user;
    public function __construct(ActionLogsService $actionLogsService,Auth $auth)
    {
        $this->actionLogsService = $actionLogsService;
        $this->user = $auth->user();
    }

    public function index()
    {
        dd($this->user);
        $rules = $this->rulesService->getRulesTree();

        return $this->view(null,compact('rules'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $rules = $this->rulesService->getRulesTree();

        return $this->view(null,compact('rules'));
    }

    /**
     * @param RuleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RuleRequest $request)
    {
        $this->rulesService->create($request->all());

        flash('添加权限成功')->success()->important();

        return redirect()->route('rules.index');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $rules = $this->rulesService->getRulesTree();
        $rule = $this->rulesService->ById($id);

        return $this->view(null,compact('rule','rules'));
    }

    /**
     * @param RuleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RuleRequest $request, $id)
    {
        $rule = $this->rulesService->ById($id);
        if(is_null($rule))
        {
            flash('你无权操作')->error()->important();
        }

        $rule->update($request->all());
        flash('更新成功')->success()->important();

        return redirect()->route('rules.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $rule = $this->rulesService->ById($id);

        if(empty($rule))
        {
            flash('删除失败')->error()->important();

            return redirect()->route('rules.index');
        }

        $rule->delete();

        flash('删除成功')->success()->important();

        return redirect()->route('rules.index');
    }

    /**
     * @param $status
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function status($status,$id)
    {
        $rule = $this->rulesService->ById($id);

        if(empty($rule))
        {
            flash('操作失败')->error()->important();

            return redirect()->route('rules.index');
        }

        $rule->update(['is_hidden'=>$status]);

        flash('更新状态成功')->success()->important();

        return redirect()->route('rules.index');
    }
}