<?php

namespace App\Http\Requests;

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
        $store = $this->route('store');

        return [
            'name' => 'required|string|min:2',
            'address' => 'required|string|min:10',
            'link_map' => 'required|url',
            'phone' => 'required|string|min:8|unique:stores,phone,'.$store->id,
            'code' => 'required|unique:stores,code,'.$store->id,
            'image_id' => 'nullable',
            'description' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống.',
            'code.required' => 'Mã không được bỏ trống.',
            'name.min' => 'Tên phải có ít nhất 2 ký tự.',
            'address.required' => 'Địa chỉ không được bỏ trống.',
            'address.min' => 'Địa chỉ phải có ít nhất 10 ký tự.',
            'link_map.required' => 'Địa chỉ bản đồ không được bỏ trống.',
            'link_map.url' => 'Địa chỉ bản đồ không hợp lệ.',
            'phone.required' => 'Số điện thoại không được bỏ trống.',
            'phone.min' => 'Số điện thoại phải có ít nhất 8 ký tự.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'code.unique' => 'Mã đã tồn tại.',
            'image.image' => 'File tải lên phải là một hình ảnh.',
            'description.required' => 'Mô tả không được bỏ trống.',
        ];
    }
}
