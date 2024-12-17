<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Xác định người dùng có quyền gửi yêu cầu này không.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Xử lý phân quyền nếu cần thiết
    }

    /**
     * Quy tắc validation cho yêu cầu.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:5',
            'category_id' => 'required|exists:service_categories,id',
            'description' => 'nullable',
            'price' => 'required|integer|min:0',
            'duration' => 'required|numeric|min:1',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên dịch vụ không được để trống.',
            'name.min' => 'Tên dịch vụ phải có ít nhất 5 ký tự.',
            'category_id.required' => 'Danh mục không được để trống.',
            'category_id.exists' => 'Danh mục không tồn tại.',
            'price.required' => 'Giá dịch vụ không được để trống.',
            'price.integer' => 'Giá dịch vụ phải là một nguyên dương.',
            'price.min' => 'Giá dịch vụ phải lớn hơn hoặc bằng 0.',
            'duration.required' => 'Thời lượng không được để trống.',
            'duration.numeric' => 'Thời lượng phải là một số.',
            'duration.min' => 'Thời lượng phải ít nhất là 1 phút.',
        ];
    }
}
