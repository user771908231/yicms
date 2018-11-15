<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-10-4
 * Time: 上午11:40
 */

namespace App\Models\ParkingLot;

use Illuminate\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use TomLingham\Searchy\Facades\Searchy;

class Garage extends Model
{
    protected $table = "garage";
    protected $connection = 'thing-eye';
    protected $guarded = [];

    public $timestamps = false;


//    public static function remove_more(array $id){
//        return DB::table('garage_apply')
//            ->whereIn('id', $id)
//            ->delete();
//    }
    public static function getInfoById($userId,$acId){
        return Garage::where('user_id','=',$userId)->where('address_id','=',$acId)->first();
    }

    /**
     * 获取指定用户指定公司/小区车位
     * @param $userId
     * @param $acId
     * @return mixed
     */
    public static function getAllInfoById($userId,$acId){
        $re= Garage::where('user_id','=',$userId)->where('address_id','=',$acId)->first();
        return $re;
    }

    /**
     * 添加数据
     * @param array $array
     * @return mixed
     */
    public static function addGarage(array $array){
        return Garage::create($array);
    }

    /**
     * 删除
     * @param $userId
     * @param $ac_id
     * @return mixed
     * @internal param array $array
     */
    public static function deleteByUser($userId,$ac_id){
        return Garage::where('user_id',$userId)->where('address_id',$ac_id)->delete();
    }

    /**
     * 根据where更新array
     * @param array $array
     * @param array $where
     * @return mixed
     */
    public static function updateGarage(array $array,array $where){
        return Garage::where($where)->update($array);
    }

    /**
     * 获取某社区所有车位列表
     * @param $ac
     */
    public static function getGarageByAc($ac,$num=15){
        if ($num==0){
            return Garage::where('address_id','=',$ac)->join('users','garage.user_id','=','users.id')->select('garage.*','users.truename','users.phone')->get();
        }else{
            return Garage::where('address_id','=',$ac)->join('users','garage.user_id','=','users.id')->select('garage.*','users.truename','users.phone')->paginate(15);
        }
    }

    /**
     * 获取指定条件
     * @param array $array
     * @return mixed
     */
    public static function getGarageByIdAndAc(array $array){
        return Garage::where($array)->first();
    }

    /**
     * @param $keywords
     * @param $ac
     */
    public static function getInfoByKeywords($keywords,$ac){

//        DB::connection()->enableQueryLog(); // 开启查询日志
//        DB::table('users'); // 要查看的sql
        $re = Garage::where('address_id','=',$ac)
            ->join('users','garage.user_id','=','users.id')
            ->select('garage.*','users.truename','users.phone');
        $row = $re
            ->where('truename','like','%'.$keywords.'%')
            ->orwhere('license_plate','like','%'.$keywords.'%')
            ->orwhere('phone','like','%'.$keywords.'%')
            ->where('address_id','=',$ac)->orderBy('id', 'DESC')
            ->paginate(15);

//        dd($row);
//        $queries = DB::getQueryLog(); // 获取查询日
//        print_r($queries); // 即可查看执行的sql，传
//        dd($row);
        $row->appends(['keywords'=>$keywords])->links();

        return $row;
    }

    public static function getInfoByPlate($plate,$admin_ac_id){
        return Garage::where('license_plate','like','%'.$plate.'%')->where('address_id','=',$admin_ac_id)->first();
    }
}