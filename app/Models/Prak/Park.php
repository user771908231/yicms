<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-10-9
 * Time: 下午2:44
 */

namespace App\Models\Park;
use App\Models\Access\AccessControl;
use App\Models\Bill\Bill;
use App\User;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Park extends Model
{
    protected $connection='thing-eye';
    protected $table = "parking_car";

    protected $guarded = [];

    public $timestamps = false;

    public static function getParkingByAcId($id)
    {
        return Park::where('ac_id','=',$id)->orderBy('id', 'DESC')->paginate(15);
    }
    public static function getAllParking()
    {
        return Park::select('*')->orderBy('id', 'DESC')->paginate(15);
    }

    public static function getParkingInfoById($id){
        return Park::where("id","=",$id)->first();
    }
    public static function getParkingByPlate($plate){
        return Park::where("license_plate","=",$plate)->where('go_out','=','0')->first();
    }

    public static function removeParking(array $id){
//        $array = array();
//        $array['go_out'] = time();

        $re = DB::table('parking_car')
            ->whereIn('id', $id)
            ->update(['go_out'=>time()]);
        return $re;
    }

    public static function getParkingByPlateOrDate($plate,$from,$to){
        $row = Park::when($plate, function ($query) use ($plate) {
                return $query->where('license_plate', $plate);
            })->when($from, function ($query) use ($from) {
                return $query->where('go_in','>',$from);
            })->when($to, function ($query) use ($to) {
                return $query->where('go_out','<',$to);
            })
           ->orderBy('id', 'DESC')->paginate(15);
        $date = array();
        if ($plate){
            $date['license_plate']=$plate;
        }
        if ($from){
            $date['from']=$from;
        }
        if ($to){
            $date['to']=$to;
        }
        $row->appends($date)->links();
        return $row;
    }

    public static function updatedBillById($billId,$id){
        return Park::where('id','=',$id)->update(['bill_id'=>$billId]);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class,'id','bill_id')
            ->select('id','order_state','unit_price');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id')
            ->select('id','truename');
    }

    public function access()
    {
        return $this->hasOne(AccessControl::class,'ac_id','ac_id')
            ->select('ac_id','ac_name','ac_address','unit_price');
    }
}