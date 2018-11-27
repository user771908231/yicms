<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/23
 * Time: 13:11
 */

namespace App\Http\Controllers\Admin\Coupon;


use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Coupon\CouponRequest;
use App\Models\Coupon\Coupon;
use Illuminate\Support\Facades\Auth;

class GenerateCouponController extends BaseController
{
    protected $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function index()
    {
        $lists = $this->coupon->where('merchant_id',Auth::id())->paginate(20);
        return $this->view()->with('lists',$lists);
    }

    public function create()
    {
        $auth = Auth::user();
        $dot = $auth->attribute->with('dot')->first()->dot;
        $available_dot = '';
        foreach ($dot as $key => $val){
            if (!$available_dot){
                $available_dot = $val['id'];
            }else{
                $available_dot .= ','.$val['id'];
            }
        }
        return $this->view()->with('available_dot',$available_dot);
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

    public function store(CouponRequest $couponRequest)
    {
        if($this->coupon->insertToArray($couponRequest->only(['name','face_value','available_dot','start_time','expire_time','type','number']))){
            flash('生成卡券成功')->success()->important();
        }else{
            flash('生成卡券失败')->error()->important();
        }
        return redirect()->route('generate-coupon.index');
    }

    /**
     * @Title : destroy
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/27
     * @Time  : 8:45
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $coupon = $this->coupon->find($id);
        if ($coupon->ser_id){
            flash('卡券删除失败,已有用户领取')->error()->important();
        }else{
            $coupon->delete();
            flash('卡券删除成功')->success()->important();
        }
        return redirect()->route('generate-coupon.index');

    }
}