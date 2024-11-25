<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
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
            'name' => 'required|min:2',
            'address' => 'required|min:10',
            'link_map' => 'required|string',
            'phone' => 'required|min:8',
            'image' => 'required_without:old_image|image|mimes:jpg,jpeg,png|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống.',
            'name.min' => 'Tên phải có ít nhất 2 ký tự.',

            'address.required' => 'Địa chỉ không được bỏ trống.',
            'address.min' => 'Địa chỉ phải có ít nhất 10 ký tự.',

            'link_map.string' => 'Vị trí phải là một chuỗi hợp lệ.',
            'link_map.required' => 'Vị trí không được để trống.',

            'phone.required' => 'Số điện thoại không được bỏ trống.',
            'phone.min' => 'Số điện thoại phải có ít nhất 8 ký tự.',

            'image.required_without' => 'Cần phải cung cấp ảnh mới nếu không có ảnh cũ.',
            'image.image' => 'Tệp tải lên phải là một hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpg, jpeg, png.',
            'image.max' => 'Ảnh không được lớn hơn 5MB.',
        ];
    }
}
