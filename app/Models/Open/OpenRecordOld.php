<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 16:58
 */

namespace App\Models\Open;


use Illuminate\Database\Eloquent\Model;

class OpenRecordOld extends Model
{
    protected $table='open_record_old';

    protected $connection = 'thing-eye';

    protected $primaryKey='v_id';
}