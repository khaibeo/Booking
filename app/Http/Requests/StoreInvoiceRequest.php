<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'name' => 'required|max:255',
            'phone' => ['required', 'regex:/^0(3[2-9]|5[6|8|9]|7[0|6-9]|8[1-5]|9[0-9])[0-9]{7}$/'],
            'payment_method' => 'required|in:cash,transfer',
            'services' => 'required|array|min:1',
            'services.*.id' => 'required|exists:services,id',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'max' => ':attribute tối đa :max kí tự',
            'regex' => ':attribute không đúng định dạng',
            'in' => ':attribute không hợp lệ',
            'array' => ':attribute phải là một mảng',
            'min' => ':attribute tối thiểu :min',
            'exists' => ':attribute không tồn tại',
            'integer' => ':attribute phải là số nguyên',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên khách hàng',
            'phone' => 'Số điện thoại',
            'payment_method' => 'Phương thức thanh toán',
            'services' => 'Dịch vụ',
            'services.*.id' => 'Mã dịch vụ',
        ];
    }
}
