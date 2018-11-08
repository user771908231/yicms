<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 13:22
 */

namespace App\Models;


use App\Models\Open\OpenRecordOld;
use App\Models\Open\OpenRecord;
use Illuminate\Database\Eloquent\Model;

class AdminAttribute extends Model
{
    protected $table='admin_attribute';

    protected $primaryKey="id";

    protected $with=[
        'user',
        ];

    /**
     * @Title : name
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/7
     * @Time  : 13:48
     */
    public function acc()
    {
        return 1;
    }

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
}