@extends('layouts.booking')

@section('booking')
    <main id="page-container">
        <div class="content">
            <a href="{{ route('choose-store') }}" class="btn btn-primary mb-3">Quay lại</a>

            <div class="block block-rounded side-scroll">
                <div class="block-content p-0 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-4 col-lg-5 overflow-hidden d-flex align-items-center">
                            <a href="">
                                <img class="img-fluid img-link" src="{{ Storage::url($store->image?->path) }}"
                                    alt="">
                            </a>
                        </div>
                        <div class="col-md-8 col-lg-7 row">
                            <div class="col px-4 py-3">
                                <h2 class="mb-1">
                                    <a class="text-dark" href="">{{ $store->name }}</a>
                                </h2>
                                <div class="fs-sm mb-2 lines">
                                    Địa chỉ: {{ $store->address }}<br>
                                    Số điện thoại: {{ $store->phone }}
                                </div>
                                <h5 class="mb-1">Thời gian hoạt động</h5>
                                @if ($storeSchedules->count() > 0)
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Giờ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($storeSchedules as $schedule)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d/m/Y') }}
                                                    </td>
                                                    <td>{{ $schedule->opening_time }} đến {{ $schedule->closing_time }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="py-3 d-flex justify-content-end align-items-end">
                                        <button class="btn btn-primary fs-sm"><a class="text-white"
                                                href="{{ route('booking-detail', $store) }}">Đặt lịch ngay</a></button>
                                    </div>
                                @else
                                    <div>
                                        <p class="py-3 text-warning">Xin lỗi, cửa hàng chưa có lịch hoạt động trong 3 ngày tới !                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="w-100">
            <iframe src="{{ $store->link_map }}" width="100%" height="450" style="border:0;" allowfullscreen=""
                loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded mt-2"></iframe>
            <hr class="w-100">
            <!-- Accordion Examples -->
            {{-- <div class="mb-3">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Khuyến mãi</h3>
                    </div>
                    <div class="block-content pb-3">
                        Hiện tại cửa hàng chưa có khuyến mãi.
                    </div>
                </div>

            </div> --}}
        </div>
    </main>
@endsection
@section('js')
@endsection
