<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        $regex = 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        return [
            'name' => 'required',
            'slogan' => 'nullable',
            'logo' => 'nullable',
            'contact_phone' => 'nullable',
            'contact_email' => 'nullable|email',
            'facebook' => ['nullable', $regex],
            'instagram' => ['nullable', $regex],
            'youtube' => ['nullable', $regex],
            'messenger' => ['nullable', $regex],
            'linkedin' => ['nullable', $regex],
            'zalo' => ['nullable', $regex],
            'tiktok' => ['nullable', $regex],
        ];
    }

    public function messages()
    {
        return [
            'name' => 'Tên không được bỏ trống',
            'email' => 'Email không đúng định dạng',
            'regex' => 'Đường link không hợp lệ',
        ];
    }
}
