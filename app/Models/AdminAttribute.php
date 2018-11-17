<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 13:22
 */

namespace App\Models;


use App\Models\Access\AccessControl;
use App\Models\Open\OpenRecordOld;
use App\Models\Open\OpenRecord;
use Illuminate\Database\Eloquent\Model;

class AdminAttribute extends Model
{

    protected $connection = 'mysql';
    protected $table='admin_attribute';

    protected $primaryKey="id";

    protected $fillable=['admin_id','pid','ac_id','stop_up','park_number','park_type','park_time'];

//    protected $with=['user','accessControl'];

    public function user()
    {
        return $this->hasMany(Users::class,'companyID','ac_id');
    }

    public function openRecord()
    {
        sleep(5);
        return $this->hasMany(OpenRecord::class,'ac_id','ac_id');
    }

    public function openRecordOld()
    {
        sleep(5);
        return $this->hasMany(OpenRecordOld::class,'ac_id','ac_id');
    }

    public function accessControl()
    {
        return $this->hasOne(AccessControl::class,'ac_id','ac_id');
    }
}