<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    //连接用户表
    protected $table = 'users';
    protected $connection='thing-eye';
    public $timestamps = false;

    protected $hidden=[
        'password',
        'od_passwd'
    ];

    protected $casts=[
        'reg_time'   => 'date:Y-m-d H:i:s',
    ];

    public function getById(int $id)
    {
        return $this->where('id',$id)->first();
    }

    public function car()
    {
        return $this->hasMany(Car\Car::class,'user_id','id')
            ->select(['id','user_id','license_plate']);

    }

    /**
     * 更具小区id获取某小区的所有用户
     * @param $acId
     */
    public static function getCommunityUserByAcId($acId,$keywords,$num=15){
//        DB::connection()->enableQueryLog(); // 开启查询日志
//        DB::table('users'); // 要查看的sql
        if ($num == 0){
            $row =Users::select('id', 'truename', 'avatar', 'client_id','homeID', 'phone', 'have_doorID', 'reg_time', 'is_lock', 'lock_property', 'gender', 'is_verify', 'verify_type', 'od_passwd')
                ->orWhere('have_doorID','like','%'.$acId)
                ->orWhere('have_doorID','like','%'.$acId.'%')
                ->orWhere('have_doorID','like',$acId.'%')
                ->orWhere('truename','like','%'.$keywords.'%')
                ->orWhere('phone','like','%'.$keywords.'%')
                ->with('car')
                ->orderBy('id', 'DESC')
                ->get();
        }else{
            $row =Users::select('id', 'truename', 'avatar', 'client_id','homeID', 'phone', 'have_doorID', 'reg_time', 'is_lock', 'lock_property', 'gender', 'is_verify', 'verify_type', 'od_passwd')
                ->orWhere('have_doorID','like','%'.$acId)
                ->orWhere('have_doorID','like','%'.$acId.'%')
                ->orWhere('have_doorID','like',$acId.'%')
                ->orWhere('truename','like','%'.$keywords.'%')
                ->orWhere('phone','like','%'.$keywords.'%')
                ->with('car')
                ->orderBy('id', 'DESC')
                ->paginate($num);
        }
//        $queries = DB::getQueryLog(); // 获取查询日
//        print_r($queries); // 即可查看执行的sql，传
        return $row;
    }

    public static function getCompanyUserByAcId($acId,$keywords,$num=15){
        if ($num==0){
            $row =Users::where('companyID','=',$acId)
                ->select('id', 'truename', 'avatar', 'homeID', 'phone', 'companyID', 'reg_time', 'is_lock', 'lock_property', 'gender', 'is_verify', 'verify_type', 'od_passwd')
                ->orWhere('truename','like','%'.$keywords.'%')
                ->orWhere('phone','like','%'.$keywords.'%')
                ->with('car')
                ->orderBy('id', 'DESC')
                ->get();
        }else{
            $row =Users::where('companyID','=',$acId)
                ->select('id', 'truename', 'avatar', 'homeID', 'phone', 'companyID', 'reg_time', 'is_lock', 'lock_property', 'gender', 'is_verify', 'verify_type', 'od_passwd')
                ->orWhere('truename','like','%'.$keywords.'%')
                ->orWhere('phone','like','%'.$keywords.'%')
                ->with('car')
                ->orderBy('id', 'DESC')
                ->paginate($num);
        }

        return $row;
    }

    public function getWhole()
    {

    }

    public static function getCommunityUserByAcIdAndKeywords($acId,$keywords,$num=15){

        if ($num == 0){
            $row =Users::select('id', 'truename', 'avatar', 'client_id','homeID', 'phone', 'have_doorID', 'reg_time', 'is_lock', 'lock_property', 'gender', 'is_verify', 'verify_type', 'od_passwd')
                ->where(function($query) use ($keywords){
                    $query->where('truename', 'like', "%{$keywords}%")
                        ->orWhere('phone', 'like', "%{$keywords}%");
                })
                ->where(function($query) use ($acId){
                    $query->where('have_doorID','like','%'.$acId)
                        ->orwhere('have_doorID','like','%'.$acId.'%')
                        ->orwhere('have_doorID','like',$acId.'%');
                })
                ->orderBy('id', 'DESC')
                ->get();
        }else{
            $row =Users::select('id', 'truename', 'avatar', 'client_id','homeID', 'phone', 'have_doorID', 'reg_time', 'is_lock', 'lock_property', 'gender', 'is_verify', 'verify_type', 'od_passwd')
                ->where(function($query) use ($keywords){
                    $query->where('truename', 'like', "%{$keywords}%")
                        ->orWhere('phone', 'like', "%{$keywords}%");
                })
                ->where(function($query) use ($acId){
                    $query->where('have_doorID','like','%'.$acId)
                        ->orwhere('have_doorID','like','%'.$acId.'%')
                        ->orwhere('have_doorID','like',$acId.'%');
                })
                ->orderBy('id', 'DESC')
                ->paginate(15);
        }
        return $row;
    }

    public static function getCommunityUserByAcIdAndKeywordsCar($acId,$keywords,$num=15){

        if ($num == 0){
            $row =Users::select('id', 'truename', 'avatar', 'client_id','homeID', 'phone', 'have_doorID', 'reg_time', 'is_lock', 'lock_property', 'gender', 'is_verify', 'verify_type', 'od_passwd')
                ->where(function($query) use ($keywords){
                    $query->where('truename', 'like', "%{$keywords}%")
                        ->orWhere('phone', 'like', "%{$keywords}%");
                })
                ->where(function($query) use ($acId){
                    $query->where('have_doorID','like','%'.$acId)
                        ->orwhere('have_doorID','like','%'.$acId.'%')
                        ->orwhere('have_doorID','like',$acId.'%');
                })
                ->orderBy('id', 'DESC')
                ->get();
        }else{
            $row =Users::select('id', 'truename', 'avatar', 'client_id','homeID', 'phone', 'have_doorID', 'reg_time', 'is_lock', 'lock_property', 'gender', 'is_verify', 'verify_type', 'od_passwd')
                ->where(function($query) use ($keywords){
                    $query->where('truename', 'like', "%{$keywords}%")
                        ->orWhere('phone', 'like', "%{$keywords}%");
                })
                ->where(function($query) use ($acId){
                    $query->where('have_doorID','like','%'.$acId)
                        ->orwhere('have_doorID','like','%'.$acId.'%')
                        ->orwhere('have_doorID','like',$acId.'%');
                })
                ->orderBy('id', 'DESC')
                ->paginate(15);
        }
        return $row;
    }

}
