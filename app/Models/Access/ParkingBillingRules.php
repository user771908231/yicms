<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/9
 * Time: 17:23
 */

namespace App\Models\Access;


use Illuminate\Database\Eloquent\Model;

class ParkingBillingRules extends Model
{
    protected $table = "parking_billing_rules";

    protected $connection="thing-eye";

//    protected $fillable = ['rules','is_reset','free','overtime','celling','special','type','ac_id'];


//    protected $with=['access'];
    public $timestamps = false;

    public function access()
    {
        return $this->hasOne(AccessControl::class,'ac_id','ac_id');
    }

}