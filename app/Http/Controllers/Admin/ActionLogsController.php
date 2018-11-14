<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActionLog;
use App\Services\ActionLogsService;

class ActionLogsController extends BaseController
{
    protected $actionLogsService;

    /**
     * ActionLogsController constructor.
     * @param $actionLogsService
     */
    public function __construct(ActionLogsService $actionLogsService)
    {
        $this->actionLogsService = $actionLogsService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $actions = $this->actionLogsService->getActionLogs();

        return $this->view(null,compact('actions'));
    }

    /**
     * @Title : destroy
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/7
     * @Time  : 15:53
     * @param ActionLog $actionLog
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ActionLog $actionLog,int $id)
    {
        if($actionLog->getById($id)->delete()){
            flash('删除成功')->success()->important();
        }else{
            flash('删除失败')->success()->important();
        }
        return redirect()->route('actions.index');
    }
}
