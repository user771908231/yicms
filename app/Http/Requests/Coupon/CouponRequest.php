<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/23
 * Time: 15:24
 */

namespace App\Http\Requests\Coupon;


use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|between:3,50',
            'face_value'=>'required|numeric',
            'available_dot'=>'required|between:1,50',
//            'start_time'=>'date',
//            'expire_time'=>'date',
            'type'=>'required|numeric',
            'number'=>'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => '票券名不能为空',
            'phone.between'      => '票券名长度应该在3~50位之间',
            'face_value.required'  => '面值不能为空',
            'face_value.numeric'   => '面值必须为数字',
            'available_dot.required' => '网点不能为空',
            'available_dot.between' =>'网点长度应该在1~50位之间',
            'start_time.date'  => '必须为有效日期',
            'expire_time.date'  => '必须为有效日期',
            'type.required' => '状态不能为空',
            'type.numeric' =>'状态必须为数字',
            'number.required' => '票券数不能为空',
            'number.numeric' =>'票券数须为数字',
        ];
    }

}