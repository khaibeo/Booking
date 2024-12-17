<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffScheduleRequest extends FormRequest
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
            'date_range' => ['required', 'array', 'min:1'],
            'date_range.*' => [
                'required',
                'date',
                'after_or_equal:today',
                Rule::unique('staff_schedules', 'date')->where(function ($query) {
                    return $query->where('user_id', $this->user()->id);
                }),
            ],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ];
    }

    public function messages()
    {
        return [
            'date_range.required' => 'Vui lòng chọn ít nhất một ngày làm việc',
            'date_range.array' => 'Danh sách ngày làm việc không hợp lệ',
            'date_range.min' => 'Vui lòng chọn ít nhất một ngày làm việc',
            'date_range.*.required' => 'Ngày làm việc là bắt buộc',
            'date_range.*.date' => 'Ngày làm việc không đúng định dạng',
            'date_range.*.after_or_equal' => 'Ngày làm việc không được nằm trong quá khứ',
            'date_range.*.unique' => 'Bạn đã đăng ký lịch làm việc cho ngày :input rồi',
            'start_time.required' => 'Giờ bắt đầu là bắt buộc',
            'start_time.date_format' => 'Giờ bắt đầu không đúng định dạng giờ:phút',
            'end_time.required' => 'Giờ kết thúc là bắt buộc',
            'end_time.date_format' => 'Giờ kết thúc không đúng định dạng giờ:phút',
            'end_time.after' => 'Giờ kết thúc phải sau giờ bắt đầu',
        ];
    }

    public function attributes()
    {
        return [
            'date_range' => 'Ngày làm việc',
            'start_time' => 'Giờ bắt đầu',
            'end_time' => 'Giờ kết thúc',
        ];
    }
}
