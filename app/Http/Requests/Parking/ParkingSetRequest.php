<?php

namespace App\Http\Requests\Parking;

use Illuminate\Foundation\Http\FormRequest;

class ParkingSetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ac_name'           => 'required|between:1,50',
            'ac_address'        => 'required|between:1,50',
            'ac_type'           => 'integer|between:1',
            'unit_price'        => 'required:integer|between:1,6',
            'is_open'           => 'required:integer|between:1',
            'ac_province'       => 'integer|between:1,5',
            'ac_region'         => 'integer|between:1,5',
            'garage_number'     => 'required:integer|between:1,5',
            'pay_parking_time'  => 'required:integer|between:1,6',
            'business_number'   => 'between:1,18',
            'business_pic'      => 'between:1,500',
            'phone'             => 'integer|between:1,11',
            'garage_number_all' => 'integer',
            'coordinate'        => 'required:integer',
        ];
    }

    public function messages()
    {
        return [
            'parent_id.integer'  => '表单不合法',
            'name.required'      => '权限名称不能为空',
            'name.between'       => '权限名称长度应该在1~20位之间',
            'fonts.max'          => '菜单图标不能超过128个字符',
            'route.max'          => '权限路由不能超过256个字符',
            'sort.required'      => '排序不能为空',
            'sort.integer'       => '表单不合法',
            'is_hidden.required' => '是否隐藏选项不能为空哦',
            'is_hidden.integer'  => '表单不合法',
            'status.required'    => '状态不能为空',
            'status.integer'     => '表单不合法',
        ];
    }
}
