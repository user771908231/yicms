<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-10-9
 * Time: 下午2:44
 */

namespace App\Models\Access;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;


class AccessControl extends Model
{
    protected $connection="thing-eye";

    protected $table = "access_control";

    protected $with=['rules'];

    protected $fillable = ['ac_name','ac_address','ac_type','ac_city','unit_price','is_open','ac_province','ac_region','garage_number','pay_parking_time','business_number','business_pic','phone','garage_number_all','coordinate'];

    protected $primaryKey = 'ac_id';

    public $timestamps = false;

    /**
     * @Title : getById
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/11
     * @Time  : 14:14
     * @param $aar
     * @return mixed
     */
    public function getById( $aar)
    {
        return $this->where($aar)->first();
    }

    public function rules()
    {
        return $this->hasOne(ParkingBillingRules::class,'ac_id','ac_id');
    }





   

}