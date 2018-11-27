<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/23
 * Time: 17:12
 */

namespace App\Models\Recharge;


use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;


class Consumption extends Model
{
    protected $table='consumption';

    protected $fillable = ['type','amount_money','data','merchant_id'];

    protected $primaryKey='id';

//    protected $attributes=['data'];
    /**
     * @Title : consumptionLog
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/26
     * @Time  : 9:13
     */
    public static  function consumptionLog(array $data)
    {
        Consumption::create($data);
    }


    /**
     * data数据修饰器
     * @param $value
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return json_decode($value,true);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class,'id','merchant_id');
    }
}