<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 11:35
 */

namespace App\Http\Controllers\Admin\Parking;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Open\OpenRecord;
use App\Models\ParkingLot\Garage;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParkingLotController extends BaseController
{
   protected $users;
   protected $garage;
    public function __construct(Users $users,Garage $garage)
   {
       $this->users = $users;
       $this->garage = $garage;
   }

    public function index()
    {
        $ac_id = Auth::user()->attribute->ac_id;
        if ($_GET){
            if (isset( $_GET['keywords'])){
                $lists = Garage::getInfoByKeywords($_GET['keywords'],$ac_id);
            }else{
                $lists = Garage::getGarageByAc($ac_id);
            }
        }else{
            $lists = Garage::getGarageByAc($ac_id);
        }

        return $this->view()->with(['lists'=>$lists,'ac_id'=>$ac_id]);
    }

    public function create()
    {
        return $this->view();
    }

    public function update(int $id)
    {
        dd($id);
    }

    public function show()
    {

    }

    public function edit(int $id,Request $request)
    {
        $val = $request->only(['ac_id','type']);
        $Info = Garage::getInfoById($id,$val['ac_id']);
        //判断主商户 子商户
        if ($Info->admins->admin_id == $Info->admins->pid){
            if ($val['type']){
                $Info->increment('number');
            }else{
                $Info->decrement('number');
            }
            return redirect()->route('parking-lot.index');
        }else{
            if ($val['type']){
                if($Info->admins->is_park_number == 0){
                    flash('添加失败,没有可添加的车位了')->error()->important();
                }else{
                    $Info->increment('number');
                    $Info->admins->decrement('is_park_number');
                    flash('添加成功')->success()->important();
                }
                return redirect()->route('parking-lot.index');
            }else{
                $Info->decrement('number');
                $Info->admins->increment('is_park_number');
                flash('修改成功')->success()->important();
                return redirect()->route('parking-lot.index');
            }
        }


    }

    /**
     * @Title : store
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/17
     * @Time  : 9:49
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $val = $request->only(['phone','number']);
        $user = $this->users->where('phone','=',$val['phone'])->first();
        $attribute = Auth::user()->attribute;
        $doorArr = explode(',',$user->have_doorID);
        $result = array_search($attribute->ac_id,$doorArr);
        //判断子商户 和是否有车位
//        dd($attribute);
        if ($attribute->admin_id != $attribute->pid)
        {
            //子商户 可用车位数
            if ($attribute->is_park_number == 0)
            {
                flash('添加失败,没有可添加的车位了')->error()->important();
                return  redirect()->route('parking-lot.create');
            }
        }else{
            if(!($attribute->stop_up == 1) ){
                if ($result === false){
                    flash('添加失败')->error()->important();
                    return  redirect()->route('parking-lot.create');
                }}
        }

        $garageInfo = Garage::getInfoById($user->id,$attribute->ac_id);
        if ($garageInfo){
            $garageInfo->increment('number',$val['number']);
            //减去商户的可用车位数
            $attribute->decrement('is_park_number',$val['number']);
            flash('添加成功')->success()->important();
            return  redirect()->route('parking-lot.index');
        }
        $data = [
            'user_id'=>$user->id,
            'address_id'=>$attribute->ac_id,
            'number' =>$val['number'],
            'admin' => $attribute->admin_id == $attribute->pid ? null : $attribute->admin_id,
        ];
        $re = Garage::addGarage($data);
        if ($re){
            flash('添加成功')->success()->important();
            return  redirect()->route('parking-lot.index');
        }
        flash('添加失败')->error()->important();
        return  redirect()->route('parking-lot.create');
    }

    public function destroy(OpenRecord $openRecord,int $id)
    {
        if($openRecord->getById($id)->delete()){
            flash('删除成功')->success()->important();
        }else{
            flash('删除失败')->error()->important();
        }
        return redirect()->route('parking.index');
    }

    /**
     * @Title : search
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/17
     * @Time  : 9:49
     * @param Request $request
     * @return string
     */
    public function search(Request $request)
    {
        $val = $request->only(['phone','type']);
        $user = $this->users->where('phone','=',$val['phone'])->first();
        $ac_id = Auth::user()->attribute->ac_id;
        if ($user){
            if(Auth::user()->attribute->stop_up == 1)
            {
                return json_encode($this->switchName($user->truename));
            }
            if ($val['type'] == "1"){
                $doorArr = explode(',',$user->have_doorID);
                if (array_search($ac_id,$doorArr) === false){
                    return json_encode("NOT_FOUND_OWNER");
                }
            }
            return json_encode($this->switchName($user->truename));
        }else{
            return json_encode("NOT_FOUND");
        }
    }

    function switchName($name)
    {
        $length = mb_strlen($name);
        $first = mb_substr($name, 0, 1);
        $number = $length - 1;
        $hidden = "";
        for ($i = 0; $i < $number; $i++) {
            $hidden .= "*";
        }
        $name = $first . $hidden;
        return $name;
    }
}