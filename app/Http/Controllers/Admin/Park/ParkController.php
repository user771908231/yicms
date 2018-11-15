<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 11:35
 */

namespace App\Http\Controllers\Admin\Park;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Bill\Bill;
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
        $park = $this->praking->find($id)->with(['bill','access'])->first();
        if (!empty($park)){
            if ((int)$request->only(['type']) == 1){
                if ($park->go_out !=  0){
                    flash('NO_PARKING_CAR')->error()->important();
                    return redirect()->route('park.index');
                }
                if ($park->bill){
                    if ($park->bill->order_state == 20 && $park->bill->expire_time >= time())
                    {

                        flash('HAVE_PAID_ORDER')->error()->important();
                        return redirect()->route('park.index');
                    }
                }
                if (!$park->access){
                    flash('NOT_FOUND_AC')->error()->important();
                    return redirect()->route('park.index');
                }
                $obj_bill = new Bill();
                $obj_bill->sn = 0000000001;
                $obj_bill->com_id =$park->access->ac_id;
                $obj_bill->com_name = $park->access->ac_name;
                $obj_bill->unit_price =  $park->access->unit_price;
                $obj_bill->order_amount = ceil((time() - $park->go_in)/3600) * $park->access->unit_price + $park->base_total;
                $obj_bill->license = $park->license_plate;
                $obj_bill->parking_time = time() - $park->go_in;
                $obj_bill->user_id =$park->user_id;
                $obj_bill->add_time = time();
                $obj_bill->order_state = 30;
                $obj_bill->expire_time = $park->go_in+ceil((time() - $park->go_in)) < 900 ?
                    time() + 900 :$park->go_in+ceil((time() - $park->go_in));
                $obj_bill->pay_parking_time =ceil((time() - $park->go_in));
                if($obj_bill->save()){
                    $park->update(['bill_id' => $obj_bill->id,'go_out'=>time()]);
                    $park->access->increment('garage_number');
                    flash('操作成功')->success()->important();
                    return redirect()->route('park.index');
                }
                flash('SYS_EEROR')->error()->important();
                return redirect()->route('park.index');
            }else{
                $bill = $park->bill;
                if ($bill){
                    switch ($bill->order_state){
                        case 0:
                            flash('订单取消')->success()->important();
                            return redirect()->route('park.index');
                            break;
                        case 10:
                            flash('未支付')->error()->important();
                            return redirect()->route('park.index');
                            break;
                        case 30:
                            flash('已出库')->error()->important();
                            return redirect()->route('park.index');
                            break;
                    }
                }else{
                    flash('订单已删除')->error()->important();
                    return redirect()->route('park.index');
                }

                $park->go_out = time();
                $park->bill->order_state = 30;
                if ($park->save())
                {
                    flash('操作成功')->success()->important();
                }
                flash('操作失败')->error()->important();
                return redirect()->route('park.index');
            }
        }else{
            flash('没有哦！')->error()->important();
            return redirect()->route('park.index');
        }

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