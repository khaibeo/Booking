@extends('layouts.booking')

@section('booking')
    <main id="page-container">
        <div class="content row d-fex justify-content-center">
            <div class="block block-rounded col-md-8">
                <div class="block-header justify-content-center pb-0">
                    <h3 class="m-0">Thông tin đặt lịch</h3>
                </div>
                <div class="block-content block-content-full space-y-3">
                    <div class="card">
                        <div class="card-body" id="booking-summary">
                            <div class="summary-section">
                                <h5>Dịch vụ đã chọn</h5>
                                <ul>
                                    @foreach ($booking->services as $service)
                                        <li>{{$service->name}} - {{$service->price}}đ</li>
                                    @endforeach
                                </ul>
                                <p class="font-weight-bold">Tổng tiền:  {{ $booking->total_amount }} đ</p>
                            </div>
                            <div class="summary-section">
                                <h5>Thông tin đặt lịch</h5>
                                <p>Cửa hàng: {{ $booking->store?->name }}</p>
                                <p>Địa chỉ: {{ $booking->store?->address }}</p>
                                <p>Nhân viên: {{ $booking->user?->name }}</p>
                                <p>Thời gian: {{ Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}, ngày {{ Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</p>
                            </div>
                            <div class="summary-section">
                                <h5>Thông tin khách hàng</h5>
                                <p>Họ tên: {{ $booking->name }}</p>
                                <p>Số điện thoại: {{ $booking->phone }}</p>
                                <p>Ghi chú: {{ $booking->note }}</p>
                            </div>

                            <div class="btn-group">
                                <a href="{{ route('choose-store') }}" class="btn btn-primary">Quay lại trang chủ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
