<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StaffScheduleRequest;
use App\Http\Requests\Admin\UpdateStaffScheduleRequest;
use App\Models\StaffSchedule;
use App\Services\StaffScheduleService;
use App\Services\StoreService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class StaffScheduleController extends Controller
{
    protected $staffScheduleService;

    protected $storeService;

    public function __construct(StaffScheduleService $staffScheduleService, StoreService $storeService)
    {
        $this->staffScheduleService = $staffScheduleService;
        $this->storeService = $storeService;
    }

    public function index()
    {
        $schedules = $this->staffScheduleService->getStaffSchedules();

        return view('admin.staff_schedules.index', compact('schedules'));
    }

    public function create()
    {
        $user = auth()->user();
        $store = $user->store;
        $storeSchedules = $this->storeService->getStoreSchedules();

        return view('admin.staff_schedules.create', compact('storeSchedules'));
    }

    public function store(StaffScheduleRequest $request)
    {
        $validatedData = $request->validated();
        $user = auth()->user();

        $dateRange = $validatedData['date_range'];
        $startTime = $validatedData['start_time'];
        $endTime = $validatedData['end_time'];

        $successCount = 0;
        $errors = new MessageBag;

        foreach ($dateRange as $date) {
            $storeSchedule = $this->storeService->checkStoreSchedule($user, $date);

            if (! $storeSchedule) {
                $errors->add('date_range', "Không tìm thấy lịch làm việc của cửa hàng cho ngày {$date}.");

                continue;
            }

            if (! $this->isWithinStoreHours($startTime, $endTime, $storeSchedule)) {
                $errors->add('time_range', "Thời gian làm việc không phù hợp với giờ mở cửa của cửa hàng cho ngày {$date}.");

                continue;
            }

            $scheduleData = [
                'user_id' => $user->id,
                'date' => $date,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ];

            try {
                $this->staffScheduleService->createSchedule($scheduleData);
                $successCount++;
            } catch (\Exception $e) {
                $errors->add('general', "Lỗi khi đăng ký lịch cho ngày {$date}: ".$e->getMessage());
            }
        }

        if ($successCount > 0) {
            $request->session()->flash('success', "Đã đăng ký thành công {$successCount} lịch làm việc.");
        }

        if ($errors->isNotEmpty()) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        return redirect()->back()->with('success', 'Đăng ký lịch làm việc thành công.');
    }

    public function edit(StaffSchedule $staffSchedule)
    {
        // Kiểm tra quyền
        $check = $this->checkUser($staffSchedule);

        if (! $check) {
            return redirect()->route('admin.staff.schedules.index')->with('error', 'Bạn không có quyền chỉnh sửa.');
        }

        $store = Auth::user()->store;
        $storeSchedules = $this->storeService->getStoreSchedules();

        return view('admin.staff_schedules.edit', compact('staffSchedule', 'storeSchedules'));
    }

    public function update(UpdateStaffScheduleRequest $request, StaffSchedule $staffSchedule)
    {
        $check = $this->checkUser($staffSchedule);

        if (! $check) {
            return redirect()->route('admin.staff.schedules.index')->with('error', 'Bạn không có quyền chỉnh sửa.');
        }

        $validatedData = $request->validated();

        // Lấy lịch làm việc của cửa hàng cho ngày được chọn
        $storeSchedule = $this->storeService->checkStoreSchedule(auth()->user(), $validatedData['date']);

        if (! $storeSchedule) {
            return redirect()->back()
                ->with('error', 'Không tìm thấy lịch làm việc của cửa hàng cho ngày này.')
                ->withInput();
        }

        // Kiểm tra xem thời gian làm việc mới có nằm trong giờ mở cửa của cửa hàng không
        if (! $this->isWithinStoreHours($validatedData['start_time'], $validatedData['end_time'], $storeSchedule)) {
            return redirect()->back()
                ->with('error', 'Thời gian làm việc không phù hợp với giờ mở cửa của cửa hàng.')
                ->withInput();
        }

        // Cập nhật lịch làm việc
        $staffSchedule->update($validatedData);

        return redirect()->route('admin.staff.schedules.index')
            ->with('success', 'Cập nhật lịch làm việc thành công.');
    }

    public function destroy(StaffSchedule $staffSchedule)
    {
        $check = $this->checkUser($staffSchedule);

        if (! $check) {
            return redirect()->route('admin.staff.schedules.index')->with('error', 'Bạn không có quyền xóa.');
        }

        $staffSchedule->delete();

        return redirect()->route('admin.staff.schedules.index')->with('success', 'Xóa thành công.');
    }

    private function isWithinStoreHours($startTime, $endTime, $storeSchedule)
    {
        $start = Carbon::parse($startTime)->format('H:i');
        $end = Carbon::parse($endTime)->format('H:i');
        $openingTime = Carbon::parse($storeSchedule->opening_time)->format('H:i');
        $closingTime = Carbon::parse($storeSchedule->closing_time)->format('H:i');

        return $start >= $openingTime && $end <= $closingTime;
    }

    private function checkUser(StaffSchedule $staffSchedule)
    {
        if (Auth::id() !== $staffSchedule->user_id) {
            return false;
        }

        return true;
    }
}
