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
}
