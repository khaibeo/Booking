<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OpenStoreRequest extends FormRequest
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
            'store_id' => 'required|exists:store,id',
            'date' => 'required|date|after_or_equal:today',
            'opening_time' => [
                'required',
                'regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/',
                'date_format:H:i',
            ],
            'closing_time' => [
                'required',
                'regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/',
                'date_format:H:i',
                'after:opening_time',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'store_id.required' => 'Vui lòng nhập id cửa hàng.',
            'store_id.exists' => 'Không tìm thấy id cửa hàng.',
            'date.required' => 'Vui lòng nhập ngày.',
            'date.date' => 'Ngày không hợp lệ.',
            'data.after_or_equal' => 'Ngày phải lớng hơn hoặc bằng ngày hiện tại.',
            'opening_time.required' => 'Vui lòng nhập giờ mở cửa.',
            'opening_time.regex' => 'Giờ mở cửa không đúng định dạng.',
            'opening_time.date_format' => 'Giờ mở cửa không đúng định dạng giờ phút giây.',
            'closing_time.required' => 'Vui lòng nhập giờ đóng cửa.',
            'closing_time.regex' => 'Giờ đóng cửa không đúng định dạng.',
            'closing_time.date_format' => 'Giờ đóng cửa không đúng định dạng giờ phút giây.',
            'closing_time.after' => 'Giờ đóng cửa phải sau giờ mở cửa.',
        ];
    }
}
