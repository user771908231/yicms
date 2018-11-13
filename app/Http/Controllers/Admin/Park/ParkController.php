<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 11:35
 */

namespace App\Http\Controllers\Admin\Park;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Park\Park;
use Illuminate\Http\Request;

class ParkController extends BaseController
{
    protected $praking;
    public function  __construct(Park $parking)
    {
        $this->praking = $parking;
    }

    public function index()
    {

        $lists = $this->praking->where('ac_id',\Auth::user()->attribute->ac_id)
            ->with(['bill','user','access'])->orderBy('id', 'desc')->paginate(20);
//        dd($lists);
        return $this->view()->with('lists',$lists);
}

    public function create()
    {

    }

    public function update(Request $request,int $id)
    {
//        dd( $request->only('type'),$id);
        $park = $this->praking->find($id)->with('bill')->first();
        if (!empty($park)){
            if ($request->only(['type']) == 1){

            }else{
                $bill = $park->bill->find($id);
                if ($bill){
                    switch ($bill->order_state){
                        case 0:
                            flash('订单取消')->success()->important();
                            return redirect()->route('lists.index');
                            break;
                        case 10:
                            flash('未支付')->success()->important();
                            return redirect()->route('lists.index');
                            break;
                        case 30:
                            flash('已出库')->error()->important();
                            return redirect()->route('lists.index');
                            break;
                    }
                }else{
                    flash('订单已删除')->error()->important();
                    return redirect()->route('lists.index');
                }

            }
        }else{
            flash('没有哦！')->error()->important();
            return redirect()->route('park.index');
        }


        flash('你无权操作')->error()->important();



        flash('更新成功')->success()->important();

        return redirect()->route('lists.index');
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