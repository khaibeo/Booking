<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->route('user');

        return $user && $user->id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Hãy nhập mật khẩu hiện tại',

            'new_password.required' => 'Hãy nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu phải tối thiểu 6 kí tự',

            'confirm_password.required' => 'Hãy nhập lại mật khẩu mới',
            'confirm_password.same' => 'Mật khẩu nhập lại không trùng khớp',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ!',
            'errors' => $validator->errors(),
        ], 422));
    }

    protected function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException(response()->json([
            'status' => 403,
            'success' => false,
            'message' => 'Quyền truy cập bị từ chối.',
        ], 403));
    }
}
