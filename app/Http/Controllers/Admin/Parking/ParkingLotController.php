<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 11:35
 */

namespace App\Http\Controllers\Admin\Parking;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Open\OpenRecord;
use App\Models\ParkingLot\Garage;
use Illuminate\Support\Facades\Auth;

class ParkingLotController extends BaseController
{
    public function index()
    {
//        dd(Auth::user());
        $lists = Garage::getGarageByAc(Auth::user()->attribute->ac_id);
//        $lists = Auth::user()->attribute->openRecord()->orderBy('time', 'desc')->paginate(20);
//        $lists = OpenRecord::getLists(Auth::user()->attribute->ac_id);
//        dd($this->view(),$lists);
        return $this->view()->with('lists',$lists);
    }

    public function create()
    {

    }

    public function update(int $id)
    {

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

    public function destroy(OpenRecord $openRecord,int $id)
    {
        if($openRecord->getById($id)->delete()){
            flash('删除成功')->success()->important();
        }else{
            flash('删除失败')->success()->important();
        }
        return redirect()->route('parking.index');
    }
}