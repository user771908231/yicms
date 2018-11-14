<?php namespace App\Models\Bill;

use App\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;



class Bill extends Model
{
    //  批量赋值时的白名单
    protected $connection="thing-eye";
    protected $table='bills';
    //  protected $fillable = [];
    //黑名单
    protected $guarded = [];

    protected $dates = [];

    protected $with=['user'];
    //取消自带时间戳录入
    public $timestamps = false;

    protected $casts=[
        'add_time'   => 'date:Y-m-d H:i:s',
        'payment_time'   => 'date:Y-m-d H:i:s',
    ];

    protected $dateFormat=[
        'add_time',
        'payment_time'
    ];

    public function getByCmid(int $com_id)
    {
        return $this->where('com_id',$com_id)->orderBy('payment_time', 'desc')->paginate(20);
    }

    public function user()
    {
        return $this->hasOne(Users::class,'id','user_id')->select('id','truename');
    }
    /**
     * 获取用户已支付临时车牌订单 （外部判断是否过期等）
     * @param $sn
     * @param $userID
     * @return bool
     */
    public static function getPaidNewCar($sn,$userID){
        $bill = Bill::where([
            'sn' => $sn,
            'user_id' => $userID,
            'order_state' => '20'
        ])->first();
        if($bill){
            if(strlen($bill->license) == 6 ){
                return $bill;
            }
        }
        return false;
    }


    /**
     * 生成账单
     * @param $bill
     * @param $parking_car_id
     * @return bool
     */
    public static function create_bill($bill, $parking_car_id)
    {
        $id = Bill::insertGetId($bill);
        if (empty($id)) {
            return false;
        } else {
            return ParkingCar::where('id', '=', $parking_car_id)->update(['bill_id' => $id]);
        }

    }
    /**
     * 生成账单 v2
     * @param $bill
     * @param $parking_car_id
     * @return bool
     */
    public static function create_bill_new($bill, $parking_car_id)
    {
        $id = Bill::insertGetId($bill);
        if (empty($id)) {
            return false;
        } else {
            ParkingCar::where('id', '=', $parking_car_id)->update(['bill_id' => $id]);
            return $id;
        }

    }

    /**
     * 生成账单
     * @param $bill
     * @param $parking_car_id
     * @return bool
     */
    public static function createBillGetID($bill, $parking_car_id)
    {
        $id = Bill::insertGetId($bill);
        if (empty($id)) {
            return false;
        } else {
            $res = ParkingCar::where('id', '=', $parking_car_id)->update(['bill_id' => $id]);
            if ($res) {
                return $id;
            }
            return false;
        }

    }


    /**
     * 取得账单数据
     * @param $sn
     * @return mixed
     */
    public static function getBill($sn)
    {
        return Bill::where('sn', '=', $sn)->first();
    }


    /**
     * 获取指定订单
     * @param $id
     * @return mixed
     */
    public static function getBillById($id)
    {
        return Bill::where('id', '=', $id)->first();
    }

    /**
     * 获取某人的所有订单
     * @param $user_id
     * @return mixed
     */
    public static function getBillByUserId($user_id)
    {
        return Bill::where('user_id', '=', $user_id)->get();
    }

    /**
     * 获取指定车辆的指定人员订单
     * @param $user_id
     * @param $plate
     * @return mixed
     */
    public static function getBillByUserIdAndPlate($user_id, $plate)
    {
        return Bill::where([
            ['user_id', '=', $user_id],
            ['license', '=', $plate]
        ])->get();
    }

    /**
     * 获取某人某车已付款的订单
     * @param $userId
     * @param $plate
     * @return mixed
     */
    public static function getPayByUserIdAndLicenseAndTime($userId, $plate)
    {
        return Bill::where([
            ['user_id', '=', $userId],
            ['license', '=', $plate],
            ['order_state', '=', '20'],
        ])->get();
    }

    /**
     * 获取某人某车已付款的订单（未过期） (wap  ParkingController #128 )
     * @param $userId
     * @param $plate
     * @return mixed
     */
    public static function getExpirePayByUserIdAndLicenseAndTime($userId, $plate)
    {
        return Bill::where([
            ['user_id', '=', $userId],
            ['license', '=', $plate],
            ['order_state', '=', '20'],
            ['expire_time', '>=', time()],
        ])->get();
    }

    /**
     * 获取指定用户未过期已支付的账单 (wap  ParkingController #66 )
     * @param $user_id
     * @return mixed
     */
    public static function getPaidBill($user_id)
    {
        return Bill::where([
            ['user_id', '=', $user_id],
            ['order_state', '=', '20'],
            ['expire_time', '>=', time()],
        ])->first();
    }

    /**
     * 根据车牌和用户id 获取未失效的订单
     * @param $user_id
     * @param $plate
     * @return mixed
     */
    public static function getLastBill($user_id, $plate)
    {
        return Bill::where([
            ['user_id', '=', $user_id],
            ['license', '=', $plate],
            ['expire_time', '>', time()],
        ])->first();
    }

    /**
     * 取消订单 (wap  ParkingController #59 )
     * @param $sn
     * @return mixed
     */
    public static function cancelBill($sn)
    {
        return Bill::where('sn', '=', $sn)->update([
            "order_state" => 0
        ]);
    }

    /**
     * 获取指定用户的指定id账单(wap  PayController #44 )
     * @param $sn
     * @param $userId
     * @return mixed
     * @internal param $id
     *
     */
    public static function getBillByIdAndUserId($sn, $userId)
    {
        return Bill::where([
            ['user_id', '=', $userId],
            ['sn', '=', $sn]
        ])->first();
    }

    /**
     * 支付成功后更改账单状态
     * @param $sn
     * @param $pay_sn
     * @param $payment_code
     * @param $payment_time
     * @param int $state
     * @return mixed
     */
    public static function updateBillToPay($sn, $pay_sn, $payment_code, $payment_time, $state = 20)
    {
        if ($state == 30) {
            $bill = Bill::getBill($sn);
            ParkingCar::updateOutTimeByBillID($bill->id, $bill->add_time);
        }

        return Bill::where('sn', '=', $sn)->update([
            "order_state" => $state,
            "pay_sn" => $pay_sn,
            "payment_code" => $payment_code,
            "payment_time" => $payment_time
        ]);
    }

    /**
     * 车辆出库后账单结束
     * @param $ac_id
     * @param $bill_id
     * @param int $pay_time
     * @return bool
     */
    public static function endBill($ac_id, $bill_id, $pay_time = 0)
    {
        $bill['order_state'] = 30;
        if ($pay_time != 0) {
            $bill['payment_time'] = $pay_time;
        }
        try {
            DB::beginTransaction();
            $res = Bill::where('id', '=', $bill_id)->update([
                "order_state" => 30
            ]);
            if (!$res) {
                Log::error("endBill Bill Update error Stack trace: ", ['bill_id' => $bill_id]);
                throw new Exception();
            }
            Access::incGarageNum($ac_id);
            $result = ParkingCar::updateOutTimeByBillID($bill_id, time());
            if (!$result) {
                Log::error("endBill ParkingCar Update error Stack trace: ", ['bill_id' => $bill_id]);
                throw new Exception();
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }

    }

    /**
     * 余额支付
     * @param $userInfo
     * @param $array
     * @param $bill_obj
     * @param $amount
     * @return bool
     */
    public static function pre_pay($userInfo, $array, $bill_obj, $amount)
    {
        $user_id = $userInfo->id;
        try {
            DB::beginTransaction();
            $res = User::updateInfoByID_cache($user_id, $array);
            if (!$res) {
                Log::error("updateInfoByID_cache User Update error Stack trace: ", ['id' => $user_id]);
                throw new Exception();
            }
            $pay_log = PDLog::addLogGetId($user_id, $userInfo->truename, 'parkingPay', $amount);
            if (!$pay_log) {
                Log::error("addLog PDLog Add error Stack trace: ", ['id' => $user_id]);
                throw new Exception();
            }
            $log = PDLog::getLogById($pay_log);
            $results = Bill::updateBillToPay($bill_obj->sn, $pay_log, 'pd_pay', $log->add_time, 20);
            if (!$results) {
                Log::error("updateBillToPay Bill update error Stack trace: ", ['pay_sn' => $bill_obj->sn]);
                throw new Exception();
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * 根据支付方单号查询账单
     * @param $pay_sn
     * @return mixed
     */
    public static function getBillByPaySN($pay_sn)
    {
        return Bill::select('sn', 'com_name', 'unit_price', 'license', 'parking_time', 'add_time', 'payment_code', 'payment_time', 'order_amount', 'pd_amount', 'order_state', 'expire_time', 'pay_parking_time')->where('pay_sn', '=', $pay_sn)->first();
    }

    /**
     * 获取某车辆的当前订单(其他用户)  (wap ParkingController #53)
     * @param $plate
     * @return mixed
     */
    public static function getBillByPlate($plate)
    {
        return Bill::where('license', '=', $plate)
            ->where('expire_time', '>', time())
            ->whereIn('order_state', [10, 20])
            ->first();
    }


    /**
     * 取得一个最新的已付款未出库账单
     * @param $license
     * @return mixed
     * @internal param $user_id
     */
    public static function getOneBillOrderByID($license)
    {
        return Bill::where([
            ['license', '=', $license],
            ['order_state', '=', '20'],
        ])->orderBy('id', 'desc')->first();
    }



    /**
     * 获取未支付的有效订单
     * @param $license
     * @return mixed
     */
    public static function getNoPayBillByLicense($license)
    {
        return Bill::where([
            ['license', '=', $license],
            ['order_state', '=', '10'],
            ['expire_time', '>=', time()],
        ])->first();
    }

    /**
     * 根据车牌取得一个最新出库订单
     * @param $license
     * @return mixed
     */
    public static function getGoOutBillByLicense($license)
    {
        return Bill::where([
            ['license', '=', $license],
            ['order_state', '=', '30']
        ])->orderBy('id', 'desc')->first();
    }






    /**
     * 取得一个最新的已付款未出库账单
     * @deprecated
     * @param $user_id
     * @return mixed
     * @see getOneBillOrderByID
     * @goto 新版APP上线后删除废弃代码 弃用类似函数
     */
    public static function getOneBillByUserIDOrderByID($user_id)
    {
        return Bill::where([
            ['user_id', '=', $user_id],
            ['order_state', '=', '20'],
        ])->orderBy('id', 'desc')->first();
    }

    /**
     * 获取未支付的有效订单 (wap ParkingController #57)
     * @deprecated
     * @param $user_id
     * @return mixed
     * @see getNoPayBillByLicense
     */
    public static function getNoPayBill($user_id)
    {
        return Bill::where([
            ['user_id', '=', $user_id],
            ['order_state', '=', '10'],
            ['expire_time', '>=', time()],
        ])->first();
    }

    /**
     * @deprecated
     * @param $user_id
     * @return mixed
     * @see getGoOutBillByLicense
     */
    public static function getGoOutBill($user_id)
    {
        return Bill::where([
            ['user_id', '=', $user_id],
            ['order_state', '=', '30']
        ])->orderBy('id', 'desc')->first();
    }

    /**
     * 更新该账单为逃单账单
     * @param $bill_id
     */
    public static function updateBillToFlee($bill_id){
        return Bill::where('id',$bill_id)->update([
            "order_state" => 40
        ]);
    }
}
