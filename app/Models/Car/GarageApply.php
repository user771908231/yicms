<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-10-4
 * Time: 上午11:40
 */

namespace App\Models\Car;

use App\Models\Users;
use Illuminate\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use PDOException;
class GarageApply extends Model
{
    protected $connection="thing-eye";

    protected $table = "garage_apply";

    protected $guarded = [];

    public $timestamps = false;

    public static function getInfoById($id){
        $info = GarageApply::where('id','=',$id)->first();
        return $info;
    }


    public static function index(){
        $info = GarageApply::select('*')->with('user')->paginate(15);

        return $info;
    }

    public static function getGarageByAc($ac_id){
        $info = GarageApply::where('address','=',$ac_id)->orderBy('id', 'DESC')->paginate(15);

        return $info;
    }



    public static function remove($id){
        return GarageApply::where('id','=',$id)->delete();
    }

    public static function remove_more(array $id){
        return DB::table('garage_apply')
            ->whereIn('id', $id)
            ->delete();
    }

    public static function add(array $array){
        return GarageApply::create($array);
    }

    public static function agreeGarageById($id,$user_id,$address){//同意通过事务操作多个数据库

        try {
            $re = Garage::getInfoById($user_id,$address);
            DB::beginTransaction();
            DB::table('garage_apply')->where('id','=',$id)->update(['state' => 1]);
            if ($re){  //之前是否有车库  有则更新以前车库  以前车位数加一
                $num = $re->number;
                $array['number'] = $num + 1;
                DB::table('garage')->where('user_id','=',$user_id)->where('address_id','=',$address)->update($array);
            }else{  //没有 则添加车库
                $array['user_id'] = $user_id;
                $array['number'] = 1;
                $array['address_id'] = $address;
                DB::table('garage')->insert($array);
            }
            DB::commit();
            return true;
        } catch (PDOException $ex) {
            DB::roll();
            return false;
        }
    }

    public static function refuseGarageById($id){
        $garage = GarageApply::getInfoById($id);
        $state = $garage->state;
        if ($state == 1){ //已同意过的请求删除一个车位（有车位）
            $userId= $garage->user_id;
            $address= $garage->address;
            $garageInfo = Garage::getInfoById($userId,$address);
            if ($garageInfo){
                $num = $garageInfo->number;
                if ($num != 0){
                    $num -= 1;
                    $data['number'] = $num;
                    $where['user_id'] = $userId;
                    $where['address_id'] = $address;
                    Garage::updateGarage($data,$where);
                }else{
                    return '无法删除车辆';
                }
            }
        }
        return GarageApply::where('id','=',$id)->update(['state' => 2]);
    }

    public static function getAllGarageByAc($ac_id,$num=15){
//        $info = GarageApply::where('address','=',$ac_id)->orderBy('id', 'DESC')->paginate(15);
//
//        DB::connection()->enableQueryLog(); // 开启查询日志
//        DB::table('users'); // 要查看的sq
        if ($num==0){
            $re = GarageApply::where('address','=',$ac_id)
                ->join('users','garage_apply.user_id','=','users.id')
                ->select('garage_apply.*','users.truename','users.phone')->orderBy('id', 'DESC')
                ->get();
        }else{
            $re = GarageApply::where('address','=',$ac_id)
                ->join('users','garage_apply.user_id','=','users.id')
                ->select('garage_apply.*','users.truename','users.phone')->orderBy('id', 'DESC')
                ->paginate(15);

        }
//        $queries = DB::getQueryLog(); // 获取查询日
//        print_r($queries); // 即可查看执行的sql，传
//        dd($re);

        return $re;

    }
    public static function getGarageByAcAndKeywords($ac_id,$keywords){
        $re = GarageApply::where('address','=',$ac_id)
            ->join('users','garage_apply.user_id','=','users.id')
            ->select('garage_apply.*','users.truename','users.phone');
        $row = $re
            ->where('truename','like','%'.$keywords.'%')
            ->orwhere('remark','like','%'.$keywords.'%')
            ->orwhere('phone','like','%'.$keywords.'%')
            ->where('address','=',$ac_id)->orderBy('id', 'DESC')
            ->paginate(15);

        $row->appends(['keywords'=>$keywords])->links();

        return $row;

    }

    public function user()
    {
        return $this->hasOne(Users::class,'id','user_id')->select(['id','truename','phone']);
    }
}