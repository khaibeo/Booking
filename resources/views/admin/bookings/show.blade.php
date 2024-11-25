@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Chi tiết lịch đặt</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            @if (auth()->user()->role == 'manager')
                                <a href="{{ route('admin.bookings.index') }}" style="color: inherit;">Lịch đặt</a>  
                            @else
                                <a href="{{ route('admin.staff.bookings.index') }}" style="color: inherit;">Lịch đặt</a>  
                            @endif
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Dịch vụ</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter fs-sm">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">STT</th>
                                <th>Tên dịch vụ</th>
                                <th class="text-end" style="width: 20%;">Giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookingDetail as $item)
                                <tr>
                                    <td class="text-center"><a href="#"><strong>{{ $loop->iteration }}</strong></a>
                                    </td>
                                    <td><a href="#"><strong>{{ $item->service->name }}</strong></a></td>
                                    <td class="text-end">{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                </tr>
                            @endforeach


                            <tr class="table-active">
                                <td colspan="2" class="text-end text-uppercase"><strong>Tổng tiền:</strong></td>
                                <td class="text-end"><strong>{{ number_format($booking->total_amount, 0, ',', '.') }}
                                        đ</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <!-- Billing Address -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Thông tin đặt lịch</h3>
                    </div>
                    <div class="block-content">
                        <div class="fs-4 mb-1">{{ $booking->store->name }}</div>
                        <address class="fs-sm">
                            {{ $booking->store->address }}<br>
                            <i class="fa fa-phone"></i> {{ $booking->store->phone }}<br>
                        </address>
                        <div class="fs fs-md">
                            <p>Ngày đặt:
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') . ' ' . $booking->booking_time }}
                            </p>
                            <p>Nhân viên: {{ $booking->user->name }}</p>
                            <p>Ghi chú: {{ $booking->note }}</p>
                        </div>
                    </div>
                </div>
                <!-- END Billing Address -->
            </div>
            <div class="col-sm-6">
                <!-- Shipping Address -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Thông tin khách hàng</h3>
                    </div>
                    <div class="block-content">
                        <div class="fs-4 mb-1">{{ $booking->name }}</div>
                        <address class="fs-sm">
                            <i class="fa fa-phone"></i> {{ $booking->phone }}<br>
                        </address>
                    </div>
                </div>
                <!-- END Shipping Address -->
            </div>
        </div>
    </div>
@endsection
