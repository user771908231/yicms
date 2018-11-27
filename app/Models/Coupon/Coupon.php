<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/23
 * Time: 13:41
 */

namespace App\Models\Coupon;


use App\Console\PublicFunction;
use Illuminate\{
    Database\Eloquent\Model, Database\Eloquent\SoftDeletes, Support\Facades\Auth
};

/**
 * @property mixed saveNumber
 */
class Coupon extends Model
{
    use SoftDeletes;
    protected $table='coupon';

    protected $fillable = ['merchant_id','name','face_value','available_dot','start_time','expire_time','is_use','user_id','type','rule','code'];

    protected $saveNumber;
    /**
     * @Title : insertToArray
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/23
     * @Time  : 16:03
     * @param array $array
     * @return
     */
    public function insertToArray(array $array)
    {
        $number = $array['number'];
        unset($array['number']);
        $array['merchant_id'] = Auth::id();
        $array['created_at'] = date('Y-m-d H:i:s',time());
        $array['updated_at'] = date('Y-m-d H:i:s',time());
        $data=[];
        for ($i=0;$i<$number;$i++){
            if (Auth::getUser()->thisAmountReduced($array)) {
                $array['code'] = PublicFunction::rand(10);
                $data[$i] = $array;
                $this->saveNumber++;
            }else{
                continue;
            }

        }
       return $this->insert($data);
    }
    /**
     * @Title : saveNumber
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/27
     * @Time  : 9:29
     * @return mixed
     */
    public function saveNumber()
    {
        return $this->saveNumber;
    }

}