@extends('layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Đăng ký lịch làm việc</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.staff.schedules.index') }}" style="color: inherit;">Lịch làm việc</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Đăng ký</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Đăng ký lịch làm việc</div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.staff.schedules.store') }}">
                            @csrf

                            <div class="form-group row mb-3">
                                <label for="date_range" class="col-md-4 col-form-label text-md-right">Chọn ngày làm
                                    việc</label>
                                <div class="col-md-6">
                                    <select id="date_range" class="form-control @error('date_range') is-invalid @enderror"
                                        name="date_range[]" required multiple>
                                        @foreach ($storeSchedules as $item)
                                            <option value="{{ $item->date }}" data-opening="{{ $item->opening_time }}"
                                                data-closing="{{ $item->closing_time }}">
                                                {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') . " ( $item->opening_time - $item->closing_time )" }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('date_range')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="start_time" class="col-md-4 col-form-label text-md-right">Giờ bắt đầu</label>
                                <div class="col-md-6">
                                    <input id="start_time" type="time"
                                        class="form-control @error('start_time') is-invalid @enderror" name="start_time"
                                        value="{{ old('start_time') }}" required>
                                    @error('start_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="end_time" class="col-md-4 col-form-label text-md-right">Giờ kết thúc</label>
                                <div class="col-md-6">
                                    <input id="end_time" type="time"
                                        class="form-control @error('end_time') is-invalid @enderror" name="end_time"
                                        value="{{ old('end_time') }}" required>
                                    @error('end_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Đăng ký
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateSelect = document.getElementById('date_range');
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');

            $('#date_range').select2({
                placeholder: 'Chọn ngày làm việc',
                allowClear: true
            });

            dateSelect.addEventListener('change', function() {
                const selectedOptions = Array.from(this.selectedOptions);
                if (selectedOptions.length > 0) {
                    const firstOption = selectedOptions[0];
                    const openingTime = firstOption.getAttribute('data-opening');
                    const closingTime = firstOption.getAttribute('data-closing');

                    if (openingTime && closingTime) {
                        startTimeInput.min = openingTime;
                        startTimeInput.max = closingTime;
                        endTimeInput.min = openingTime;
                        endTimeInput.max = closingTime;

                        startTimeInput.value = openingTime;
                        endTimeInput.value = closingTime;
                    }
                } else {
                    startTimeInput.value = '';
                    endTimeInput.value = '';
                    startTimeInput.removeAttribute('min');
                    startTimeInput.removeAttribute('max');
                    endTimeInput.removeAttribute('min');
                    endTimeInput.removeAttribute('max');
                }
            });
        });
    </script>
@endpush
