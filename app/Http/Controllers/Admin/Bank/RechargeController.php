<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/23
 * Time: 10:27
 */

namespace App\Http\Controllers\Admin\Bank;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Recharge\Recharge;
use Illuminate\{
    Http\Request, Support\Facades\Auth
};

class RechargeController extends BaseController
{
    protected $recharge;

    public function __construct(Recharge $recharge)
    {
        $this->recharge = $recharge;
    }

    /**
     * @Title : index
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/23
     * @Time  : 11:50
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keywords = $request->only('keywords');
//        dd(array_key_exists('keywords',$keywords));
        if (array_key_exists('keywords', $keywords)) {
            $lists = $this->recharge->where(['admins_id' => Auth::id(), 'deleted_at' => null])->whereDate('created_at','>=', $keywords['keywords'].' 00:00:00')->paginate(20);
            return $this->view()->with(['lists'=>$lists,'keywords'=>$keywords]);
        } else {
            $lists = $this->recharge->where(['admins_id' => Auth::id(), 'deleted_at' => null])->paginate(20);
            return $this->view()->with('lists',$lists);
        }

    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function store()
    {

    }
}