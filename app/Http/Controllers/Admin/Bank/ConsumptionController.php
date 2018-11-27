<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/23
 * Time: 10:28
 */

namespace App\Http\Controllers\Admin\Bank;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Recharge\Consumption;
use Illuminate\Support\Facades\Auth;

class ConsumptionController extends BaseController
{
    protected $consumption;

    public function __construct(Consumption $consumption)
    {
        $this->consumption = $consumption;

    }

    public function index()
    {
        $lists = $this->consumption->where('merchant_id',Auth::id())->with('admin')->orderBy('id','desc')->paginate(20);
        return $this->view()->with('lists',$lists);
    }

    public function create()
    {

    }

    public function update()
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

    public function destroy(int $id)
    {

        if($this->consumption->find($id)->delete()){
            flash('删除成功')->success()->important();
        }else{
            flash('删除失败')->error()->important();
        }
        return redirect()->route('consumption.index');
    }
}