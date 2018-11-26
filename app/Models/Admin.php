<?php

namespace App\Models;

use App\Models\Recharge\Consumption;
use App\Models\Traits\RbacCheck;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    use RbacCheck;

    protected $fillable = ['name', 'password', 'avatr', 'login_count', 'create_ip', 'last_login_ip', 'status','pid','is_top'];

    protected $rememberTokenName = '';

    protected $ability;

    protected $primaryKey='id';

    protected $with=['attribute'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * 判断某个路由当前登录管理员是否有权限访问
     * @param $route
     * @return bool true / false
     */
    public function hasRule($route)
    {
        /**获取当前用户的用户组*/

        if(in_array(1,$this->roles->pluck('id')->toArray()))
        {
            return true;
        }

        $rules = $this->getRules();

        return in_array($route, $rules);
    }

    public function attribute()
    {
        return $this->hasOne(AdminAttribute::class,'admin_id','id');
    }

    public function creates(array $attributes = [])
    {
        return tap($this->attribute()->newModelInstance($attributes),function($instance){
            dd($instance);
        });
    }

    public function consumption()
    {
        return $this->hasMany(Consumption::class,'merchant_id','id');
    }


    /**
     * @Title : thisAmountReduced
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/26
     * @Time  : 9:17
     * @param array $data ['amount'=>float,log=>[],'type'=>1]
     * @return bool
     */
    public function thisAmountReduced(array $data)
    {
//        dd($this->with('consumption'),$data);
        if ($this->amount_money > floatval($data['face_value'])){
            try{
                $this->amount_money = bcsub($this->amount_money, floatval($data['face_value']), 2);
                $this->update();
                $consumption = new Consumption();
                $consumption->fill([
                    'merchant_id'=>$this->id,
                    'type'=>0,
                    'amount_money'=>floatval($data['face_value']),
                    'data' => json_encode([
                        'time'=>time(),
                        'amount_money' => $this->amount_money
                    ])
                ]);
                $consumption->save();
                return true;
            }catch (\Exception $exception){
                return false;
            }
        }else{
            return false;
        }

    }

    public function isMain()
    {
        return $this->attribute->admin_id != 1? false : true;
    }

}
