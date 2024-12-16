<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Hãy nhập Email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Hãy nhập mật khẩu mới',
            'password.min' => 'Mật khẩu tối thiểu :min kí tự',
            'password.confirmed' => 'Mật khẩu nhập lại không trùng khớp',
        ];
    }
}
