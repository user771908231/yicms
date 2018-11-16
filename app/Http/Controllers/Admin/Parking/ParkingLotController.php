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

        if ($val['type']){
            $Info->increment('number');
        }else{
            $Info->decrement('number');
        }
        return redirect()->route('parking-lot.index');
    }

    public function store(Request $request)
    {
        $val = $request->only(['phone','number']);
        $user = $this->users->where('phone','=',$val['phone'])->first();
        $ac_id = Auth::user()->attribute->ac_id;
        $doorArr = explode(',',$user->have_doorID);
        $result = array_search($ac_id,$doorArr);
        if ($result === false){
            flash('添加失败')->error()->important();
            return  redirect()->route('parking-lot.create');
        }
        $garageInfo = Garage::getInfoById($user->id,$ac_id);
        if ($garageInfo){
            $garageInfo->increment('number',$val['number']);
            flash('添加成功')->success()->important();
            return  redirect()->route('parking-lot.index');
        }
        $data = [
            'user_id'=>$user->id,
            'address_id'=>$ac_id,
            'number' =>$val['number']
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

    public function search(Request $request)
    {
        $val = $request->only(['phone','type']);
        $user = $this->users->where('phone','=',$val['phone'])->first();
        $ac_id = Auth::user()->attribute->ac_id;
        if ($user){
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