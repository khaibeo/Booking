<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffScheduleRequest extends FormRequest
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
    public function rules()
    {
        return [
            'date' => [
                'required',
                'date',
                'after_or_equal:today',
                Rule::unique('staff_schedules')->where(function ($query) {
                    return $query->where('user_id', $this->user()->id)
                        ->where('id', '!=', $this->route('staffSchedule')->id);
                }),
            ],
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ];
    }

    public function messages()
    {
        return [
            'date.unique' => 'Bạn đã có lịch làm việc khác trong ngày này.',
            'end_time.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',
        ];
    }
}
