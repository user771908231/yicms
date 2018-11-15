<?php
/**
 * Created by PhpStorm.
 * User: thonyou
 * Date: 18-3-12
 * Time: 下午5:47
 * Email: company134@163.com
 */

namespace App\Models\Car;


use App\Models\Users;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $connection="thing-eye";
    protected $table='cars';

    public static function getCarByUserId($user,$file){
        $car = Car::select($file)->where('user_id',$user)->get();
        return $car;
    }

    public function user()
    {
        $this->hasOne(Users::class,'id','userId');
    }
}