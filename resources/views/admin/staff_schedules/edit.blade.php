@extends('layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Lịch làm việc</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.staff.schedules.index') }}" style="color: inherit;">Lịch làm việc</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Cập nhật</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Cập nhật lịch làm việc</div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.staff.schedules.update', $staffSchedule) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group row mb-3">
                                <label for="date" class="col-md-4 col-form-label text-md-right">Ngày làm việc</label>
                                <div class="col-md-6">
                                    <select id="date" class="form-control @error('date') is-invalid @enderror"
                                        name="date" required>
                                        <option value="">Chọn ngày</option>
                                        @foreach ($storeSchedules as $item)
                                            <option value="{{ $item->date }}" {{ $item->date == $staffSchedule->date->format('Y-m-d') ? 'selected' : '' }}
                                                data-opening="{{ $item->opening_time }}"
                                                data-closing="{{ $item->closing_time }}">
                                                {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y')  . " ( $item->opening_time - $item->closing_time )" }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('date')
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
                                        class="form-control @error('start_time') is-invalid @enderror" name="start_time" value="{{$staffSchedule->start_time}}"
                                        required>
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
                                        class="form-control @error('end_time') is-invalid @enderror" name="end_time" value="{{$staffSchedule->end_time}}"
                                        required>
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
                                        Cập nhật
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateSelect = document.getElementById('date');
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');

            dateSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const openingTime = selectedOption.getAttribute('data-opening');
                const closingTime = selectedOption.getAttribute('data-closing');

                if (openingTime && closingTime) {
                    startTimeInput.min = openingTime;
                    startTimeInput.max = closingTime;
                    endTimeInput.min = openingTime;
                    endTimeInput.max = closingTime;

                    startTimeInput.value = openingTime;
                    endTimeInput.value = closingTime;
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
