<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/6
 * Time: 14:42
 */

namespace App\Http\Controllers\Admin\Bank;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Bill\Bill;
use App\Models\Park\Park;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListsController extends BaseController
{
    protected $bill;
    protected $data;
    protected $page;
    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }

    public function index()
    {

        $lists = $this->bill->getByCmid(Auth::user()->attribute->ac_id);
        $this->data = $lists;
        $this->currentPage();
        return $this->view(null,compact('lists'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $rules = $this->bill->getRulesTree();

        return $this->view(null,compact('rules'));
    }

    /**
     * @param RuleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RuleRequest $request)
    {
        $this->bill->create($request->all());

        flash('添加权限成功')->success()->important();

        return redirect()->route('rules.index');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $rules = $this->bill->getRulesTree();
        $rule = $this->bill->ById($id);

        return $this->view(null,compact('rule','rules'));
    }

    /**
     * @param RuleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(int $id,Request $request)
    {
        dd(Park::getParkingInfoById($id));
        if ($request->only(['type']) == 1){

        }else{
            $bill = $this->bill->find($id);
            if ($bill){
                switch ($bill->order_state){
                    case 0:
                        flash('订单取消')->success()->important();
                        return redirect()->route('lists.index');
                        break;
                    case 10:
                        flash('未支付')->success()->important();
                        return redirect()->route('lists.index');
                        break;
                    case 30:
                        flash('已出库')->error()->important();
                        return redirect()->route('lists.index');
                        break;
                }
            }else{
                flash('订单已删除')->error()->important();
                return redirect()->route('lists.index');
            }

        }

            flash('你无权操作')->error()->important();



        flash('更新成功')->success()->important();

        return redirect()->route('lists.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request,$id)
    {
        $rule = $this->bill->getBillById($id);
        if(empty($rule))
        {
            flash('删除失败')->error()->important();

            return redirect()->route('lists.index')->with(['page'=>$this->page]);
        }

        $rule->delete();

        flash('删除成功')->success()->important();

        return redirect()->route('lists.index')->with(['page'=>$this->page]);
    }

    /**
     * @param $status
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function status(Request $request,$id)
    {
        $rule = $this->bill->ById($id);

        if(empty($rule))
        {
            flash('操作失败')->error()->important();

            return redirect()->route('rules.index');
        }

        $rule->update(['is_hidden'=>$status]);

        flash('更新状态成功')->success()->important();

        return redirect()->route('rules.index');
    }

    public function currentPage()
    {
        $this->page = $this->data->toArray()['current_page'];
    }
}