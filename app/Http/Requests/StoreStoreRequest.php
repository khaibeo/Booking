<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:stores,name',
            'address' => 'required',
            'link_map' => 'required|url',
            'phone' => 'required|min:8|unique:stores,phone',
            'image_id' => 'required',
            'code' => 'required|unique:stores,code',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống.',
            'code.required' => 'Mã không được bỏ trống.',
            'name.unique' => 'Tên này đã tồn tại.',
            'code.unique' => 'Mã này đã tồn tại.',
            'address.required' => 'Địa chỉ không được bỏ trống.',
            'link_map.required' => 'Địa chỉ bản đồ không được bỏ trống.',
            'link_map.url' => 'Địa chỉ bản đồ không hợp lệ.',
            'phone.required' => 'Số điện thoại không được bỏ trống.',
            'phone.min' => 'Số điện thoại phải có ít nhất 8 ký tự.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'image_id.required' => 'Hình ảnh không được để trống.',
        ];
    }
}
