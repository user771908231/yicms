<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/23
 * Time: 10:29
 */

namespace App\Models\Recharge;


use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    protected $connection="admins";

    protected $table="admins_recharge_record";
}