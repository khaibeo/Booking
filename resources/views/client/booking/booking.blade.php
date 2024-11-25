@extends('layouts.booking')


@section('css')
    <link rel="stylesheet" href="{{ asset('/js/plugins/slick-carousel/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('/js/plugins/slick-carousel/slick-theme.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.css" rel="stylesheet" />

    <style>
        .selected {
            background: #0dcaf0;
            border-radius: 3px;
        }

        .service-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .service-item:hover {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .service-item.selected {
            border-color: #0dcaf0;
            background: rgba(13, 202, 240, 0.1);
        }

        .time-slot {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
        }

        .time-slot:hover {
            background: rgba(13, 202, 240, 0.1);
        }

        .time-slot.selected {
            background: #0dcaf0;
            color: white;
        }

        .time-slot.disabled {
            background: #f5f5f5;
            cursor: not-allowed;
            color: #999;
        }

        .total-price {
            font-size: 1.2em;
            font-weight: bold;
            color: #0dcaf0;
            padding: 10px;
            background: rgba(13, 202, 240, 0.1);
            border-radius: 4px;
        }

        .calender {
            font-size: 60px;
            font-weight: bold;
            color: #0dcaf0;
        }

        .button-calender {
            font-weight: bold;
            font-size: 20px;
            align-items: center;
        }

        #services-container {
            max-height: 400px;
            overflow-y: scroll;
        }

        @media (max-width: 768px) {
            #services-container {
                max-height: 200px;
            }
        }
    </style>
@endsection
@section('booking')
    <main id="page-container">
        <div class="content">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Đặt lịch</h3>
                </div>
                <div class="block-content block-content-full space-y-3">
                    <div>
                        <div class="progress mb-2" style="height: 10px;" role="progressbar" aria-valuenow="33.3"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" id="progress-bar" style="width: 33.3%;"></div>
                        </div>
                        <nav class="d-flex flex-column flex-lg-row items-center justify-content-between gap-2">
                            <a href="javascript:void(0)" data-step="1"
                                class="btn btn-lg btn-alt-primary bg-transparent w-100 text-start fs-sm d-flex align-items-center justify-content-between gap-3">
                                <div class="flex-grow-0 rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                    style="width: 36px; height: 36px;">
                                    <i class="fa fa-fw fa-check"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div>Đặt lịch</div>
                                    <div class="fw-normal">Chọn dịch vụ, nhân viên, thời gian</div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" data-step="2"
                                class="btn btn-lg btn-alt-secondary bg-transparent w-100 text-start fs-sm d-flex align-items-center justify-content-between gap-3">
                                <div class="flex-grow-0 rounded-circle border border-3 border-primary d-flex align-items-center justify-content-center"
                                    style="width: 36px; height: 36px;">
                                    2
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-primary">Thông tin cá nhân</div>
                                    <div class="fw-normal">Tên và số điện thoại</div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" data-step="3"
                                class="btn btn-lg btn-alt-secondary bg-transparent w-100 text-start fs-sm d-flex align-items-center justify-content-between gap-3">
                                <div class="flex-grow-0 rounded-circle bg-body-dark d-flex align-items-center justify-content-center"
                                    style="width: 36px; height: 36px;">
                                    3
                                </div>
                                <div class="flex-grow-1">
                                    <div>Xác nhận</div>
                                    <div class="fw-normal">Xác nhận thông tin đặt lịch</div>
                                </div>
                            </a>
                        </nav>
                    </div>

                    <!-- Nội dung của từng step -->
                    <div id="step-content-1"
                        class="step-content rounded-2  bg-body-light text-muted fs-sm d-flex align-items-center justify-content-center">
                        <div class="col-md-9 rounded mt-2 block block-round p-4">
                            <div class="services-section mb-4">
                                <h4><i class="fa fa-cut fa-fw text-primary"></i> Chọn dịch vụ</h4>
                                <div class="row" id="services-container">

                                </div>
                                <div class="total-price mt-3">
                                    <input type="hidden" id="store-id" value="{{ $store->id }}">
                                    <input type="hidden" id="store-name" value="{{ $store->name }}">
                                    <input type="hidden" id="store-address" value="{{ $store->address }}">
                                    Đã chọn: <span id="total-service">0</span> dịch vụ - Tổng tiền: <span id="total-amount">0</span>đ
                                </div>
                            </div>
                            <div class="block-title  d-flex justify-content-between align-items-center ">
                                <p><i class="fa fa-play fa-fw text-primary"></i> Chọn nhân viên</p>
                                <div class="d-flex align-items-center"><label for="checkStaff"
                                        class="text-muted px-2 mb-0 fs-ms">Chọn bất kì</label>
                                    <input type="checkbox" id="checkStaff">
                                </div>
                            </div>
                            <div class="block-content">
                                <div class="js-slider" id="staff-slider">

                                </div>
                            </div>
                            <hr class="w-100">
                            <div class="block-title d-flex justify-content-between align-items-center ">
                                <p><i class="fa fa-play fa-fw text-primary"></i> Chọn thời gian</p>
                            </div>
                            <div class="block block-rounded mt-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="datepicker"></div>
                                    </div>
                                    <div class="col-md-8">
                                        <div id="time-slots">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Slider with Multiple Slides/Avatars -->
                    <div id="step-content-2"
                        class="step-content rounded-2 pb-3 bg-body-light text-muted fs-sm d-none align-items-center justify-content-center">
                        <div class="col-md-9 rounded mt-2 block block-round p-4">
                            <div class="block-title  d-flex justify-content-between align-items-center ">
                                <p><i class="fa fa-play fa-fw text-primary"></i>Nhập thông tin cá nhân</p>
                            </div>
                            <div class="block-content">
                                <form action="" id="personal-info-form">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Họ và tên</label>
                                        <input type="text" id="customer-name" class="form-control" name="name">
                                    </div>

                                    <div class="mb-3">
                                        <label for="" class="form-label">Số điện thoại</label>
                                        <input type="text" id="customer-phone" class="form-control" name="phone">
                                    </div>

                                    <div class="mb-3">
                                        <label for="" class="form-label">Ghi chú</label>
                                        <input type="text" class="form-control" name="note">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="step-content-3"
                        class="step-content rounded-2 py-3 bg-body-light text-muted fs-sm d-none align-items-center justify-content-center">
                        <div class="col-md-9 rounded mt-2 block block-round p-4">
                            <div class="col-md-8 mx-auto">
                                <h4><i class="fa fa-check fa-fw text-primary"></i> Xác nhận thông tin</h4>
                                <div class="card">
                                    <div class="card-body" id="booking-summary">

                                    </div>
                                </div>
                                <button class="btn btn-primary mt-3 justify-end" id="confirm-booking">Xác nhận đặt
                                    lịch</button>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-between align-items-center px-3 pb-3">
                        <button class="btn btn-secondary" id="prev-step" disabled>Quay lại</button>
                        <button class="btn btn-primary" id="next-step">Tiếp tục</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('js/plugins/slick-carousel/slick.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const storeId = document.querySelector('#store-id').value;
            const storeName = document.querySelector('#store-name').value;
            const storeAddress = document.querySelector('#store-address').value;

            Noty.overrideDefaults({
                layout: 'topRight',
                theme: 'sunset',
                timeout: 3000,
                progressBar: true
            });

            let bookingState = {
                currentStep: 1,
                selectedServices: [],
                selectedStaff: null,
                selectedDate: null,
                selectedTime: null,
                staffSchedule: null,
                totalAmount: 0,
                totalService: 0,
                personalInfo: {
                    name: '',
                    phone: '',
                    note: '',
                },
                storeInfo: {
                    id: storeId,
                    name: storeName,
                    address: storeAddress,
                }
            };

            // Khởi tạo các component
            initializeSteps();
            initializeServices();
            initializeStaffSlider();
            initializeDatePicker();

            // Khởi tạo các bước
            function initializeSteps() {
                const prevBtn = document.getElementById('prev-step');
                const nextBtn = document.getElementById('next-step');
                const progressBar = document.getElementById('progress-bar');

                function updateStep(step) {
                    bookingState.currentStep = step;
                    updateStepVisibility();
                    updateProgressBar();
                    updateNavigationButtons();
                }

                function updateStepVisibility() {
                    document.querySelectorAll('.step-content').forEach((content, index) => {
                        if (index + 1 === bookingState.currentStep) {
                            content.classList.remove('d-none');
                            content.classList.add('d-flex');
                        } else {
                            content.classList.add('d-none');
                        }
                    });
                }

                function updateProgressBar() {
                    const progress = ((bookingState.currentStep - 1) / 2) * 100;
                    progressBar.style.width = `${progress}%`;
                }

                function updateNavigationButtons() {
                    prevBtn.disabled = bookingState.currentStep === 1;
                    nextBtn.textContent = bookingState.currentStep === 3 ? 'Hoàn thành' : 'Tiếp tục';
                }

                prevBtn.addEventListener('click', () => {
                    if (bookingState.currentStep > 1) {
                        updateStep(bookingState.currentStep - 1);
                    }
                });

                nextBtn.addEventListener('click', () => {
                    if (validateCurrentStep()) {
                        if (bookingState.currentStep < 3) {
                            updateStep(bookingState.currentStep + 1);
                        } else {
                            submitBooking();
                        }
                    }
                });
            }

            // Khởi tạo dịch vụ và xử lí chọn
            async function initializeServices() {
                try {
                    const response = await fetch('/v1/services');

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const services = await response.json();

                    const container = document.getElementById('services-container');

                    container.innerHTML = '';

                    services.forEach(service => {
                        const serviceElement = createServiceElement(service);
                        container.appendChild(serviceElement);
                    });
                } catch (error) {
                    console.error('Error fetching services:', error);
                }
            }


            function createServiceElement(service) {
                const div = document.createElement('div');
                div.className = 'col-md-4';
                div.innerHTML = `
                    <div class="service-item" data-id="${service.id}">
                        <h5>${service.name}</h5>
                        <p>${service.description.slice(0, 100) + '...'}</p>
                        <div class='d-flex justify-content-between'>
                            <p class='mb-0'>${service.price.toLocaleString()}đ</p>
                            <p class='mb-0'><small>${service.duration} phút</small></p>
                        </div>
                    </div>
                `;

                div.querySelector('.service-item').addEventListener('click', () => {
                    toggleService(service);
                });

                return div;
            }

            function toggleService(service) {
                const index = bookingState.selectedServices.findIndex(s => s.id === service.id);
                const element = document.querySelector(`.service-item[data-id="${service.id}"]`);

                if (index === -1) {
                    bookingState.selectedServices.push(service);
                    element.classList.add('selected');
                } else {
                    bookingState.selectedServices.splice(index, 1);
                    element.classList.remove('selected');
                }

                updateTotalAmount();
                updateAvailableTimeSlots();
            }

            function updateTotalAmount() {
                bookingState.totalAmount = bookingState.selectedServices.reduce((sum, service) => sum + service
                    .price, 0);
                bookingState.totalService = bookingState.selectedServices.length;
                
                document.getElementById('total-amount').textContent = bookingState.totalAmount.toLocaleString();
                document.getElementById('total-service').textContent = bookingState.totalService;
            }

            // Xử lí chọn nhân viên
            async function initializeStaffSlider() {
                try {
                    const response = await fetch(`/v1/staff?store=${bookingState.storeInfo.id}`);

                    if (!response.ok) {
                        throw new Error('Đã xảy ra lỗi');
                    }

                    const staffs = await response.json();

                    const slider = document.getElementById('staff-slider');
                    staffs.forEach(member => {
                        const staffElement = createStaffElement(member);
                        slider.appendChild(staffElement);
                    });

                    $('.js-slider').slick({
                        dots: true,
                        arrows: true,
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        autoplay: false,
                    });

                    document.getElementById('checkStaff').addEventListener('change', (e) => {
                        if (e.target.checked) {
                            const randomIndex = Math.floor(Math.random() * staffs.length);
                            selectStaff(staffs[randomIndex]);
                        }
                    });

                } catch (error) {
                    console.error('Đã có lỗi xảy ra:', error);
                }
            }

            function createStaffElement(staff) {
                const div = document.createElement('div');
                div.setAttribute('data-staff-id', staff.id);
                div.className = 'staff-item text-center py-2';
                div.innerHTML = `
                    <img class="img-avatar mb-2" src="http://127.0.0.1:8000/storage/${staff.avatar}" alt="${staff.name}">
                    <h5 class='mb-0'>${staff.name}</h5>
                `;

                div.addEventListener('click', () => selectStaff(staff));
                return div;
            }

            async function selectStaff(staff) {
                bookingState.selectedStaff = staff;
                document.querySelectorAll('.staff-item').forEach(item => item.classList.remove('selected'));
                document.querySelector(`[data-staff-id="${staff.id}"]`).classList.add('selected');

                await fetchStaffSchedule(staff.id);

                generateDateOptions();
            }

            async function fetchStaffSchedule(staffId) {
                try {
                    const startDate = new Date().toISOString().split('T')[0];
                    const response = await fetch(`/v1/staff/${staffId}/schedule-range?start_date=${startDate}`);

                    if (!response.ok) {
                        throw new Error('Có lỗi xảy ra với lịch làm việc của nhân viên');
                    }

                    const result = await response.json();
                    bookingState.staffSchedule = result.data;
                } catch (error) {
                    console.error('Đã có lỗi xảy ra:', error);
                }
            }

            function initializeDatePicker() {
                const dateContainer = document.querySelector('#datepicker');
                dateContainer.innerHTML = `
                    <div class="form-group">
                        <select class="form-control" id="date-select">
                            <option value="">Chọn ngày</option>
                        </select>
                    </div>`;

                generateDateOptions();

                document.getElementById('date-select').addEventListener('change', function(e) {
                    if (e.target.value) {
                        bookingState.selectedDate = new Date(e.target.value);
                        updateAvailableTimeSlots();
                    }
                });
            }

            function generateDateOptions() {
                const options = [];
                const today = new Date();

                const staffSchedule = bookingState.staffSchedule || {};
                const dateSelect = document.getElementById('date-select');

                if (!dateSelect) {
                    console.error('Đã có lỗi xảy ra');
                    return;
                }

                for (let i = 0; i < 3; i++) {
                    const date = new Date(today);
                    date.setDate(today.getDate() + i);

                    const dateString = date.toLocaleDateString('sv-SE');

                    if (!bookingState.selectedStaff || staffSchedule[dateString]) {
                        const formattedDate = date.toLocaleDateString('vi-VN', {
                            weekday: 'long',
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });

                        options.push(`<option value="${dateString}">${formattedDate}</option>`);
                    }
                }

                dateSelect.innerHTML = '<option value="">Chọn ngày</option>' + options.join('');
            }

            async function generateTimeSlots(date, staff) {
                const slots = [];
                const dateString = date.toLocaleDateString('sv-SE');
                const staffSchedule = bookingState.staffSchedule[dateString];

                if (!staffSchedule || !staffSchedule.length) {
                    return slots;
                }

                // Lấy danh sách các lịch hẹn trong ngày của nhân viên
                const appointments = await fetchStaffAppointments(staff.id, date);

                const totalDuration = bookingState.selectedServices.reduce((sum, service) =>
                    sum + service.duration, 0);

                staffSchedule.forEach(schedule => {
                    const [startHour, startMinute] = schedule.start_time.split(':').map(Number);
                    const [endHour, endMinute] = schedule.end_time.split(':').map(Number);

                    const startTime = new Date(date);
                    startTime.setHours(startHour, startMinute, 0, 0);

                    const endTime = new Date(date);
                    endTime.setHours(endHour, endMinute, 0, 0);

                    const isToday = new Date().toDateString() === date.toDateString();
                    if (isToday) {
                        const now = new Date();
                        if (now > startTime) {
                            startTime.setTime(now.getTime());
                            startTime.setMinutes(Math.ceil(startTime.getMinutes() / 30) * 30);
                        }
                    }

                    while (startTime < endTime) {
                        const slotEndTime = new Date(startTime.getTime() + totalDuration * 60000);

                        if (slotEndTime <= endTime) {
                            // Kiểm tra xem slot có bị trùng với lịch hẹn nào không
                            const isOverlapping = isSlotOverlappingWithAppointment(
                                startTime,
                                slotEndTime,
                                appointments
                            );

                            slots.push({
                                time: new Date(startTime),
                                available: !isOverlapping
                            });
                        }

                        startTime.setMinutes(startTime.getMinutes() + 30);
                    }
                });

                return slots;
            }

            function updateAvailableTimeSlots() {
                if (!bookingState.selectedDate || !bookingState.selectedStaff) return;

                const timeSlots = generateTimeSlots(bookingState.selectedDate, bookingState.selectedStaff);
                renderTimeSlots(timeSlots);
            }

            function isSlotOverlappingWithAppointment(slotStart, slotEnd, appointments) {
                const buffer = 10 * 60 * 1000; // 10 phút, tính bằng milliseconds

                return appointments.some(appointment => {
                    const appointmentStart = new Date(
                        `${appointment.booking_date}T${appointment.booking_time}`);
                    const appointmentEnd = new Date(`${appointment.booking_date}T${appointment.end_time}`);

                    // Điều chỉnh khoảng thời gian với buffer 10 phút
                    const adjustedSlotStart = new Date(slotStart.getTime() + buffer);
                    const adjustedSlotEnd = new Date(slotEnd.getTime() - buffer);

                    // Kiểm tra các điều kiện trùng lặp với buffer
                    const isStartInOld = (adjustedSlotStart < appointmentEnd && adjustedSlotStart >=
                        appointmentStart);
                    const isEndInOld = (adjustedSlotEnd > appointmentStart && adjustedSlotEnd <=
                        appointmentEnd);
                    const isOldWithinNew = (appointmentStart >= adjustedSlotStart && appointmentEnd <=
                        adjustedSlotEnd);

                    return isStartInOld || isEndInOld || isOldWithinNew;
                });
            }


            async function fetchStaffAppointments(staffId, date) {
                try {
                    const response = await fetch(
                        `/v1/staff/${staffId}/appointments?date=${date.toLocaleDateString('sv-SE')}`);

                    if (!response.ok) {
                        throw new Error('Không thể lấy lịch hẹn của nhân viên');
                    }

                    const result = await response.json();
                    return result.data || [];
                } catch (error) {
                    console.error('Lỗi khi lấy lịch hẹn:', error);
                    return [];
                }
            }

            async function renderTimeSlots(slots) {
                const container = document.getElementById('time-slots');
                container.innerHTML = '';

                slots = await slots;

                slots.forEach(slot => {
                    const timeSlot = document.createElement('div');
                    timeSlot.className = `time-slot ${slot.available ? '' : 'disabled'}`;
                    timeSlot.textContent = slot.time.toLocaleTimeString('vi-VN', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    if (slot.available) {
                        timeSlot.addEventListener('click', () => selectTimeSlot(slot));
                    }

                    container.appendChild(timeSlot);
                });
            }

            function selectTimeSlot(slot) {
                bookingState.selectedTime = slot.time;
                document.querySelectorAll('.time-slot').forEach(el => el.classList.remove('selected'));
                event.target.classList.add('selected');
            }

            function validateCurrentStep() {
                switch (bookingState.currentStep) {
                    case 1:
                        if (bookingState.selectedServices.length === 0) {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Hãy chọn dịch vụ!',
                                timeout: 3000
                            }).show();
                            return false;
                        }
                        if (!bookingState.selectedStaff) {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Hãy chọn nhân viên!',
                                timeout: 3000
                            }).show();
                            return false;
                        }
                        if (!bookingState.selectedDate || !bookingState.selectedTime) {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Hãy chọn thời gian!',
                                timeout: 3000
                            }).show();
                            return false;
                        }
                        return true;

                    case 2:
                        const form = document.getElementById('personal-info-form');
                        if (form.elements.name.value.trim() == '') {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Hãy nhập họ và tên!',
                                timeout: 3000
                            }).show();
                            return false;
                        }

                        if (form.elements.phone.value == '') {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Hãy nhập số điện thoại!',
                                timeout: 3000
                            }).show();
                            return false;
                        } else {
                            if (!validateVietnamesePhone(form.elements.phone.value)) {
                                new Noty({
                                    type: 'error',
                                    layout: 'topRight',
                                    text: 'Số điện thoại không hợp lệ!',
                                    timeout: 3000
                                }).show();
                                return false;
                            }
                        }

                        bookingState.personalInfo = {
                            name: form.elements.name.value,
                            phone: form.elements.phone.value,
                            note: form.elements.note.value,
                        };
                        updateBookingSummary();
                        return true;

                    case 3:
                        return true;
                }
            }

            function updateBookingSummary() {
                const summary = document.getElementById('booking-summary');
                summary.innerHTML = `
        <div class="summary-section">
            <h5>Dịch vụ đã chọn</h5>
            <ul>
                ${bookingState.selectedServices.map(service => 
                    `<li>${service.name} - ${service.price.toLocaleString()}đ</li>`
                ).join('')}
            </ul>
            <p class="font-weight-bold">Tổng tiền: ${bookingState.totalAmount.toLocaleString()}đ</p>
        </div>
        <div class="summary-section">
            <h5>Thông tin đặt lịch</h5>
            <p>Cửa hàng: ${bookingState.storeInfo.name}</p>
            <p>Địa chỉ: ${bookingState.storeInfo.address}</p>
            <p>Nhân viên: ${bookingState.selectedStaff.name}</p>
            <p>Ngày: ${bookingState.selectedDate.toLocaleDateString('vi-VN')}</p>
            <p>Giờ: ${bookingState.selectedTime.toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit'
            })}</p>
        </div>
        <div class="summary-section">
            <h5>Thông tin khách hàng</h5>
            <p>Họ tên: ${bookingState.personalInfo.name}</p>
            <p>Số điện thoại: ${bookingState.personalInfo.phone}</p>
            <p>Ghi chú: ${bookingState.personalInfo.note}</p>
        </div>
    `;
            }

            async function submitBooking() {
                try {
                    const response = await fetch('/v1/bookings', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            services: bookingState.selectedServices.map(s => s.id),
                            staff_id: bookingState.selectedStaff.id,
                            store_id: bookingState.storeInfo.id,
                            booking_date: bookingState.selectedDate,
                            booking_time: bookingState.selectedTime,
                            customer_name: bookingState.personalInfo.name,
                            customer_phone: bookingState.personalInfo.phone,
                            note: bookingState.personalInfo.note,
                        })
                    });

                    if (response.ok) {
                        const result = await response.json();
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Đặt lịch thành công!',
                            timeout: 3000
                        }).show();

                        window.location.href = `/booking/${result.booking.id}/success`;
                    } else {
                        if (response.status === 422) {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Dữ liệu không hợp lệ, vui lòng kiểm tra lại!',
                                timeout: 3000
                            }).show();
                        } else {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Đã có lỗi xảy ra!',
                                timeout: 3000
                            }).show();
                        }
                    }

                } catch (error) {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Đã có lỗi xảy ra!',
                        timeout: 3000
                    }).show();
                }
            }

            document.querySelectorAll('[data-step]').forEach(step => {
                step.addEventListener('click', (e) => {
                    const stepNumber = parseInt(e.currentTarget.dataset.step);
                    if (stepNumber < bookingState.currentStep || validateCurrentStep()) {
                        updateStep(stepNumber);
                    }
                });
            });

            document.querySelector('#confirm-booking').addEventListener('click', () => {
                submitBooking();
            });

            function validateVietnamesePhone(phone) {
                phone = phone.replace(/[\s-]/g, '');

                const vietnamesePhoneRegex = /^(0|84|\+84)([3|5|7|8|9])([0-9]{8})$/;

                return vietnamesePhoneRegex.test(phone);
            }
        });
    </script>
@endsection
