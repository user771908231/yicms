<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-10-9
 * Time: 下午2:44
 */

namespace App\Models\Park;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Parking extends Model
{
    protected $connection='thing-eye';
    protected $table = "parking_car";

    protected $guarded = [];

    public $timestamps = false;

    public static function getParkingByAcId($id)
    {
        return Parking::where('ac_id','=',$id)->orderBy('id', 'DESC')->paginate(15);
    }
    public static function getAllParking()
    {
        return Parking::select('*')->orderBy('id', 'DESC')->paginate(15);
    }

    public static function getParkingInfoById($id){
        return Parking::where("id","=",$id)->first();
    }
    public static function getParkingByPlate($plate){
        return Parking::where("license_plate","=",$plate)->where('go_out','=','0')->first();
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
        $row = Parking::when($plate, function ($query) use ($plate) {
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
        return Parking::where('id','=',$id)->update(['bill_id'=>$billId]);
    }
}