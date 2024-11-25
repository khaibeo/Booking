@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Danh sách đặt lịch</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.staff.bookings.index') }}" style="color: inherit;">Booking</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Danh sách đặt lịch</h3>
            </div>
            <div class="block-content">
                <table class="table table-hover" id="bookingsTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="d-none d-sm-table-cell">Khách hàng</th>
                            <th class="d-none d-sm-table-cell">Thời gian</th>
                            <th class="d-none d-sm-table-cell">Trạng thái</th>
                            <td>Thao tác</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="d-none d-sm-table-cell">{{ $booking->name }}</td>
                                <td class="d-none d-sm-table-cell">
                                    {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }},
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }} </td>

                                <td class="d-none d-sm-table-cell">
                                    @if ($booking->status === 'pending')
                                        <span class="badge bg-warning">Chưa xác nhận</span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="badge bg-info">Đã xác nhận</span>
                                    @elseif($booking->status === 'completed')
                                        <span class="badge bg-success">Hoàn thành</span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.staff.bookings.show', $booking) }}"
                                            class="btn btn-sm btn-primary d-flex align-items-center"
                                            style="height: 30px; line-height: 30px;" title="Chi tiết">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>{{ $bookings->links() }}</div>
            </div>
        </div>
    </div>
@endsection
