<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $fillable = ['admin_id','data'];

    protected $primaryKey='id';
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
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

    public function getById(int $id)
    {
        return $this->where($this->primaryKey,$id)->first();
    }
}
