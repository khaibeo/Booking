@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="content">
        <div
            class="d-md-flex justify-content-md-between align-items-md-center py-3 pt-md-3 pb-md-0 text-center text-md-start">
            <div>
                <h1 class="h3 mb-1">
                    Dashboard
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Latest Orders + Stats -->
        <div class="row">
            <div class="col-md-12">
                <!--  Latest Orders -->
                <div class="block block-rounded block-mode-loading-refresh">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Lịch đặt hôm nay - <span class="p-2 badge bg-info">{{ $bookings->count() }} </span> 
                        </h3>
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
                    <div class="block-content block-content-full block-content-sm bg-body-light fs-sm text-center">
                        <a class="fw-medium" href="{{ route('admin.staff.bookings.index') }}">
                            Xem tất cả
                            <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                        </a>
                    </div>
                </div>
                <!-- END Latest Orders -->
            </div>
        </div>
        <!-- END Latest Orders + Stats -->
    </div>
    <!-- END Page Content -->
@endsection
