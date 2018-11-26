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
use App\Http\Requests\User\UserRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends BaseController
{
    protected $user;

    public function __construct(Users $users)
    {
        $this->user = $users;
    }

    public function index()
    {
        $admin_info = Auth::user();
        $ac_id =$admin_info->attribute->ac_id;
//        dd($admin_info);
        if ($admin_info->id == 0){
            if (isset( $_GET['keywords'])&&$_GET['keywords']){
                $keywords = $_GET['keywords'];
                $lists = Users::getAllByKeywords($keywords);
            }else{
                $lists = Users::lists();
            }

        }else{
            if (isset( $_GET['keywords'])&&$_GET['keywords']){
                $keywords = $_GET['keywords'];
                $lists = Users::getCommunityUserByAcIdAndKeywords($ac_id,$keywords);
            }else{
                $lists = Users::getCommunityUserByAcIda($ac_id);
            }

        }
//        return view('admin.user.index')
//                ->with('lists',Auth::user()->attribute->user()->orderBy('id', 'desc')->paginate(20));
        return view('admin.user.index')
                ->with('lists',$lists);
    }

    public function create()
    {
        return view('admin.user.create');
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

    public function store(UserRequest $userRequest)
    {
//        dd($userRequest->all());
        $val = $userRequest->only(['phone',
            'building',
            'unit',
            'home',
            'garage',
            'state']);
        $user = $this->user->where('phone',$val['phone'])->first();
        if (!$user) {
            flash('该用户尚未注册！')->error()->important();
            return redirect()->route('user.create');
        }
        if ($val['state'] != 0 && $val['state'] != 1)
        {
            flash('状态错误！')->error()->important();
            return redirect()->route('user.create');
        }
        $new_home = $this->addZero(Auth::user()->attribute->ac_id,10).$this
                ->addZero($val['building'],3).$this
                ->addZero($val['unit'],2).$this
                ->addZero($val['home'],4);
        $user_data = [
            'homeID' => $user->homeID != $user->homeID.','.$new_home?$user->homeID.','.$new_home:$new_home
        ];
        if ($user->have_doorID != Auth::user()->attribute->ac_id ){
            $user_data['have_doorID'] = $user->have_doorID.','.Auth::user()->attribute->ac_id;
        }
        if ($val['state'] == 0){
            $user_data['lock_property'] = $user->lock_property?$user->lock_property.','.Auth::user()->attribute->ac_id:Auth::user()->attribute->ac_id;
        }
        if($user->fill($user_data)->update()){
            flash('SUCCESS！')->success()->important();
        }else{
            flash('用户更新失败！')->error()->important();
        }
        return redirect()->route('user.index');
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

         switch($acc->attribute->accessControl->ac_type){
             case 0:
                 $user->companyID= null;
                 break;
         }
         $user->have_doorID=PublicFunction::explodeString($user->have_doorID,$acc->attribute->ac_id);
//         $user->homeID=PublicFunction::explodeString($user->homeID,$acc->attribute->ac_id);

        if ($user->update()){
            flash('删除成功！')->success()->important();
        }else{
            flash('删除失败！')->error()->important();
        }

        return redirect()->route('user.index');
    }

    protected function addZero($number,$all) {
        $len =strlen($number) ;
        $a = $all- $len;
        $add = "";
        for ($i=0;$i<$a;$i++){
            $add .="0";
        }
        $b = $add.''.$number;
        return $b;
    }
}