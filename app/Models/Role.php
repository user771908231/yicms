<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Role extends Model
{
    protected $fillable = ['name', 'remark', 'order', 'status','u_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function admins()
    {
        return $this->belongsToMany(Admin::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rules()
    {
        return $this->belongsToMany(Rule::class,'role_auth')->withTimestamps();
    }

    /**
     * 获取显示的权限
     * @return mixed
     */
    public function rulesPublic()
    {
        return $this->rules()->public()->orderBy('sort','asc')->get();
    }

    public function thisUser()
    {
        return $this->where('u_id',Auth::id());
    }

}
