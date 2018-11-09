<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 11:35
 */

namespace App\Http\Controllers\Admin\Users;


use App\Console\PublicFunction;
use App\Http\Controllers\Admin\BaseController;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends BaseController
{

    public function index()
    {
            return view('admin.user.index')
                ->with('lists',Auth::user()->attribute->user()->orderBy('id', 'desc')->paginate(20));
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

    /**
     * @Title : destroy
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/7
     * @Time  : 16:31
     * @param Users $users
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Users $users, int $id)
    {
        $acc = Auth::user();
        $user = $users->getById($id);
        $user->have_doorID=PublicFunction::explodeString($user->have_doorID,$acc->attribute->ac_id);
        $user->companyID=null;
        if ($user->update()){
            flash('删除成功！')->success()->important();
        }else{
            flash('删除失败！')->success()->important();
        }

        return redirect()->route('user.index');
    }
}