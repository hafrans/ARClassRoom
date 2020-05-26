<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SImageRequest extends FormRequest
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
            "name" => "bail|required|min:3|max:64",
            "meta" => "bail|nullable|min:3|max:512",
            "size" => "bail|required|digits",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "识别图片名称必须填写！",
            "name.min" => "图片名称长度过小（最小3）",
            "name.max" => "图片名称长度过长（最大64）",


            "meta.min" => "元数据长度过小(最小3)",
            "meta.min" => "元数据长度过长(最大512)",

            "size.required" => "图片大小必须填写",
            "size.digits" => "图片大小必须是数字"
        ];
    }


}
