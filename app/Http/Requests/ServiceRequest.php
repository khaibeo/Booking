<?php

namespace App\Http\Requests;

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
            'description' => 'required|string|min:10',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:1',
            // 'created_at' => 'required|date',
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
            'description.required' => 'Mô tả không được để trống.',
            'description.min' => 'Mô tả phải có ít nhất 10 ký tự.',
            'price.required' => 'Giá dịch vụ không được để trống.',
            'price.numeric' => 'Giá dịch vụ phải là một số.',
            'price.min' => 'Giá dịch vụ phải lớn hơn hoặc bằng 0.',
            'duration.required' => 'Thời lượng không được để trống.',
            'duration.numeric' => 'Thời lượng phải là một số.',
            'duration.min' => 'Thời lượng phải ít nhất là 1 phút.',
            'created_at.required' => 'Ngày tạo không được để trống.',
            'created_at.date' => 'Ngày tạo phải là định dạng ngày hợp lệ.',
        ];
    }
}
