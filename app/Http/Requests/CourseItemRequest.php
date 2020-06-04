<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CourseItemRequest extends FormRequest
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
            "course_id" => "bail|required",
            "name" => "bail|required|min:3|max:128",
            "video_path" => "bail|nullable",
            "audio_path" => "bail|nullable",
            "graph_path" => "bail|nullable",
            "model_path" => "bail|nullable",
            "content" => "bail|nullable|max:20000",
//            "captcha" => "bail|required|captcha",
        ];
    }

    public function messages()
    {
        return [
            "course_id.required" => "父级课程ID不存在",

            "name.required" => "知识点名称必须填写",
            "name.min" => "知识点名称长度过小",
            "name.max" => "知识点长度过大",


            "content.max" => "文字介绍过长",

            "captcha.required" => "验证码必须填写",
            "captcha.captcha" => '验证码无效',

        ];
    }

}
