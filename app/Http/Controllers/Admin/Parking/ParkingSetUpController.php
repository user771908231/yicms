<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 11:41
 */

namespace App\Http\Controllers\Admin\Parking;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Access\AccessControl;
use App\Models\Access\ParkingBillingRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParkingSetUpController extends BaseController
{
    protected $access;
    protected $attribute;
    public function __construct(AccessControl $access)
    {
        $this->access = $access;
    }


    public function index()
    {

        $data = $this->attributes();
        return $this->view()->with('lists',$data);
    }

    protected function attributes()
    {
       return $this->attribute =Auth::user()->attribute;
    }

    public function create()
    {

    }

    public function update(Request $request,int $id)
    {
        $value = $request->only([
            'is_open',
            'all_number',
            'type',
            'unit_price_day',
            'unit_price_hour',
            'over_time',
            'free'
        ]);
        if ($value['is_open'] == 1)
        {
            try{
                DB::beginTransaction();
                accessControl::where('ac_id',$this->attributes()->accessControl->ac_id)
                    ->update([
                        'is_open'=>$value['is_open'],
                        'unit_price' => $value['unit_price_day']?$value['unit_price_day']:$value['unit_price_hour'],
                        'garage_number_all' => $value['all_number']
                    ]);
                ParkingBillingRules::where('ac_id',$this->attributes()->accessControl->ac_id)
                    ->update([
                        'free'=>$value['free'],
                        'overtime' => $value['over_time'],
                        'type' => $value['type']
                    ]);
                DB::commit();
                flash('更新成功')->success()->important();
            }catch (\Exception $e) {
                DB::rollBack();
                flash('更新失败'.$e->getMessage())->success()->important();
            }
            return redirect()->route('parksetup.index');

        }else{

            if ($this->attributes()->accessControl->update([
                'is_open'=>$value['is_open'],
                'unit_price' => $value['unit_price_day']?$value['unit_price_day']:$value['unit_price_hour'],
                'garage_number_all' => $value['all_number']
            ])){
                flash('更新成功')->success()->important();
            }else{
                flash('更新失败')->success()->important();
            }
        }

        return redirect()->route('parksetup.index');
    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function store()
    {

    }
}