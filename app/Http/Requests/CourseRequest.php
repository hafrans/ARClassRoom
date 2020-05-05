<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            "name" => 'bail|required|unique:ar_courses|max:255|min:3',
            "description" => 'bail|required|max:255|min:3',
            "captcha" => 'bail|required|captcha'
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "课程名称必须填写",
            "name.unique" => "课程名称有重复",
            "name.max" => "课程名称过长",
            "name.min" => "课程名称过短",

            "description.required" => "课程介绍必须填写",
            "description.max" => "课程介绍过长",
            "description.min" => "课程介绍过短",

            "captcha.required" => "验证码必须填写",
            "captcha.captcha" => '验证码无效'
        ];
    }


}
