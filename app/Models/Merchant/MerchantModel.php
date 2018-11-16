<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/16
 * Time: 15:34
 */

namespace App\Models\Merchant;


use App\Models\Admin;

class MerchantModel extends Admin
{
    public function merchant()
    {
        return $this->with(['attribute'=>function($q){
            $q->where('stop_up',1);
        }])->paginate(20);
    }
}