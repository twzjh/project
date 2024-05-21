<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConnectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'tel' => 'required|digits:10',
            'email' => 'required|string|max:255|email',
            'main' => 'required|string|max:20',
            'content' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '*請輸入姓名',
            'tel.required' => '*請輸入手機號碼',
            'tel.digits' => '*手機號碼必須為10碼',
            'email.required' => '*請輸入電子郵件',
            'email.email' => '*請輸入有效的電子郵件地址',
            'main.required' => '*請輸入主旨',
            'main.max' => '*不能超過20個字',
            'content.required' => '*請輸入內容',
        ];
    }
}
