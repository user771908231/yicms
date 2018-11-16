<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/16
 * Time: 15:32
 */

namespace App\Http\Controllers\Admin\Merchant;


use App\Console\PublicFunction;
use App\Http\Controllers\Admin\BaseController;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantController extends BaseController
{
    protected $merchant;

    public function __construct(Admin $admin)
    {
        $this->merchant = $admin;
    }

    public function index()
    {
        $lists = $this->merchant->where('pid',Auth::id())->whereHas('attribute',function($q){
            $q->where('stop_up',1);
        })->paginate(20);

        return $this->view()->with('lists',$lists);
    }

    public function create()
    {

    }

    public function update(Request $request,int $id)
    {
        $var = $request->only(['name','park_number','park_time','park_type']);
        $merchant = $this->merchant->find($id);
        $var['park_time'] = $var['park_time']? $var['park_time'].' 00:00:00':$var['park_time'];
        $merchant->fill(['name'=>$var['name']]);
        $merchant->attribute->fill(PublicFunction::arrayRemove($var,'name'));
        if ($merchant->update() && $merchant->attribute->update()){
            flash('更新成功')->success()->important();
        }else{
            flash('更新失败')->success()->important();
        }
        return redirect()->route('merchant.edit',$id);
    }

    public function show()
    {

    }

    public function edit(int $id)
    {
        $merchant = $this->merchant->find($id);
        return $this->view()->with('admin',$merchant);

    }

    public function store()
    {

    }
}