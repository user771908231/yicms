<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 11:35
 */

namespace App\Http\Controllers\Admin\Parking;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Car\GarageApply;
use App\Models\Open\OpenRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParkingApplicationController extends BaseController
{

    protected $garageApply;

    public function __construct(GarageApply $garageApply)
    {
        $this->garageApply = $garageApply;
    }

    /**
     * @Title : index
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/16
     * @Time  : 9:13
     */
    public function index()
    {
        if (isset( $_GET['keywords'])&&$_GET['keywords']){
            $keywords = $_GET['keywords'];
            $lists = GarageApply::getGarageByAcAndKeywords(Auth::user()->attribute->ac_id,$keywords);
        }else{
            $lists = GarageApply::getGarageByAc(Auth::user()->attribute->ac_id,'user');
        }
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

    /**
     * @Title : edit
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/16
     * @Time  : 9:53
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(int $id, Request $request)
    {
        $info = $this->garageApply->find($id);
        if($info)
        {   if ($request->only('type')['type'] == "1")
            {
                if ($info->state == 1)  {
                    flash('NOT_FOUND')->error()->important();
                    return redirect()->route('parking-application.index');
                }
                $status = GarageApply::agreeGarageById($info->id,$info->user_id,$info->address);
            }else{
                if ($info->state == 2)  {
                    flash('NOT_FOUND')->error()->important();
                    return redirect()->route('parking-application.index');
                }
                $status = GarageApply::refuseGarageById($info->id);
            }
            if ($status){
                flash('SUCCESS')->success()->important();
            }else{
            flash('FIALL')->error()->important();
            }
            return redirect()->route('parking-application.index');
        }else{
            flash('NOT_FOUND')->error()->important();
        }

    }

    public function store()
    {

    }

    public function destroy(OpenRecord $openRecord,int $id)
    {
        if($openRecord->getById($id)->delete()){
            flash('删除成功')->success()->important();
        }else{
            flash('删除失败')->error()->important();
        }
        return redirect()->route('parking.index');
    }
}