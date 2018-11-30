<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/16
 * Time: 11:30
 */

namespace App\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

    public function rules()
    {

        switch (UserRequest::get('type'))
        {
            case "0":
                return [
                    'phone'=>'required|numeric|min:11,max:11',
                ];
                break;
            case "1":
                return [
                    'phone'=>'required|numeric|min:11,max:11',
                    'building'=>'required|numeric',
                    'unit'=>'required|numeric',
                    'home'=>'required|numeric',
                    'garage'=>'numeric',
                    'state'=>'required|numeric',
                ];
                break;
        }

    }

    public function messages()
    {
        return [
            'phone.required'     => '手机号不能为空',
            'phone.numeric'      => '手机号必须为数字',
            'phone.min'      => '手机号必须长度应该在11位',
            'phone.max'      => '手机号必须长度应该在11位',
            'building.required'  => '栋数不能为空',
            'building.numeric'   => '栋数必须为数字',
            'unit.required'  => '单元不能为空',
            'unit.numeric'   => '单元必须为数字',
            'home.required'  => '号数不能为空',
            'home.numeric'   => '号数必须为数字',
            'garage.numeric'  => '车位必数为数字',
            'state.required' => '状态不能为空',
            'state.numeric' =>'状态必须为数字',
        ];
    }
}