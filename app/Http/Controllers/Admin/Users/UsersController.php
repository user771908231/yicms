<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 11:35
 */

namespace App\Http\Controllers\Admin\Users;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;

class UsersController extends BaseController
{

    public function index()
    {
//        $lists = Auth::user()->attribute->user()->paginate(20);
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

    public function destroy(Users $users,int $id)
    {
        dd($users->getById($id));
    }
}