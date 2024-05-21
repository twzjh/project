<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'],
            'confirmPassword' => ['required', 'string','same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => '此帳號已有人使用，請確認是否輸入錯誤',
            'password.regex' => '密碼必須包含至少一個字母和一個數字',
            'password.min' => '密碼至少為8個字元',
            'confirmPassword.same' => '密碼不相符',
        ];
    }
}
