<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 11:35
 */

namespace App\Http\Controllers\Admin\Card;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Card\DoorCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoorCardController extends BaseController
{
    public function index()
    {
        $row = DoorCard::getDoorCardByCommunityId(Auth::user()->attribute->ac_id);
        return $this->view()->with("lists",$row);
    }

    public function create()
    {

    }

    public function update(int $id,Request $request)
    {
        if (DoorCard::updateById($id,$request->only(['state']))){
            flash('更新成功')->success()->important();
        }else{
            flash('更新失败')->error()->important();
        }
        return redirect()->route('household.index');
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