<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|max:255|email',
            'password' => [
                'required',
                'regex:/^\S*$/', // Kiểm tra không có khoảng trắng
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email bắt buộc phải nhập',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Độ dài kí tự không hợp lệ',
            'password.required' => 'Mật khẩu bắt buộc phải nhập',
            'password.regex' => 'Mật khẩu không được chứa khoảng trắng',
        ];
    }
}
