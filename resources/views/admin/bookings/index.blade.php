@extends('layouts.backend')

@section('css')
<style>
    .btn {
    position: relative;
}
    .table-cell-store {
    white-space: normal; 
    overflow: hidden; 
    text-overflow: ellipsis;
    word-break: break-word; 
    max-width: 100px; 
}
</style>
@endsection
@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Danh sách đặt lịch</h1>
            <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.bookings.index') }}" style="color: inherit;">Đặt lịch</a>
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
            <div class="block-options">
                <div class="block-options-item">
                </div>
            </div>
        </div>

        <div class="block-content">
            <form method="GET" action="{{ route('admin.bookings.index') }}">
                <div class="row mb-4">
                    <!-- Tìm kiếm theo tên khách hàng -->
                    <div class="col-md-3">
                        <input type="text" name="customer_name" class="form-control" placeholder="Tìm kiếm tên khách hàng" value="{{ request()->get('customer_name') }}">
                    </div>
                    
                    <!-- Lọc theo cửa hàng -->
                    {{-- <div class="col-md-3">
                        <select name="store_id" class="form-control">
                            <option value="">Tất cả cửa hàng</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}" {{ request()->get('store_id') == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                     --}}
                    <!-- Lọc theo trạng thái thanh toán -->
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" {{ request()->get('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="confirmed" {{ request()->get('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="completed" {{ request()->get('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ request()->get('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </div>
                
            </form>
        </div>

        <div class="block-content">
            <table class="table table-hover" id="bookingsTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">STT</th>
                        <th>Khách hàng</th>
                        <th class="d-none d-sm-table-cell">Thời gian</th>
                        {{-- <th class="d-none d-sm-table-cell">Cửa hàng</th> --}}
                        <th class="d-none d-sm-table-cell">Trạng thái</th>
                        <th class="text-center" style="width: 100px;">Tùy chọn</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="d-none d-sm-table-cell">{{ $booking->name }}</td>
                            <td class="d-none d-sm-table-cell">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}, {{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}</td>
                            {{-- <td class="d-none d-sm-table-cell table-cell-store">
                                {{ $booking->store ? $booking->store->name : 'N/A' }}
                            </td> --}}
                            <td class="d-none d-sm-table-cell">
                                @if($booking->status == 'pending')
                                    <span class="badge bg-warning">Chờ xử lý</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge bg-info">Đã xác nhận</span>
                                @elseif($booking->status == 'completed')
                                    <span class="badge bg-success">Hoàn thành</span>
                                @else
                                    <span class="badge bg-danger">Đã hủy</span>
                                @endif
                            </td>
                           
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{route('admin.bookings.show', $booking)}}" class="btn btn-sm btn-alt-info d-flex align-items-center"
                                            style="height: 30px; line-height: 30px;" title="Chi tiết">
                                            <i class="fa fa-eye"></i>
                                    </a>
                                    <!-- Cập nhật trạng thái -->
                                    @if($booking->status == 'completed' || $booking->status == 'cancelled')
                                        <button type="button" class="btn btn-sm btn-alt-warning mx-2"
                                            style="height: 30px; line-height: 30px; cursor: not-allowed; background-color: #e0e0e0; color: #999; border: none;"
                                            data-bs-toggle="tooltip" title="Không thể chỉnh sửa">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-alt-warning mx-2"
                                            style="height: 30px; line-height: 30px;"
                                            data-bs-toggle="modal" data-bs-target="#updateStatusModal" data-id="{{ $booking->id }}" data-status="{{ $booking->status }}" title="Chỉnh sửa">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                    @endif
                                
                                    <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" class="form-delete" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="{{ $booking->status }}">
                                        @if($booking->status == 'completed' || $booking->status == 'cancelled')
                                            <button type="button" class="btn btn-sm btn-alt-danger"
                                                style="height: 30px; line-height: 30px; cursor: not-allowed; background-color: #e0e0e0; color: #999; border: none;"
                                                data-bs-toggle="tooltip" title="Không thể hủy">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-alt-danger"
                                                style="height: 30px; line-height: 30px;"
                                                data-bs-toggle="tooltip" title="Hủy">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        @endif
                                    </form>
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

<!-- Modal Cập Nhật Trạng Thái -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Cập Nhật Trạng Thái</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStatusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="bookingId" name="booking_id">
                    <div class="mb-3">
                        <label for="statusSelect" class="form-label">Chọn trạng thái mới</label>
                        <select id="statusSelect" class="form-select" name="status">
                            <option value="pending">Chờ xử lý</option>
                            <option value="confirmed">Xác nhận</option>
                            <option value="completed">Hoàn thành</option>
                            <option value="cancelled">Hủy bỏ</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var updateStatusModal = document.getElementById('updateStatusModal');
        var statusSelect = document.getElementById('statusSelect');
        var submitBtn = document.querySelector('.modal-footer .btn-primary'); 
        var form = document.getElementById('updateStatusForm');

        updateStatusModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; 
            var bookingId = button.getAttribute('data-id');
            var bookingStatus = button.getAttribute('data-status');

            var bookingIdInput = document.getElementById('bookingId');

            bookingIdInput.value = bookingId;
            statusSelect.value = bookingStatus;

            var statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
            var currentStatusIndex = statuses.indexOf(bookingStatus);

            for (var i = 0; i < statusSelect.options.length; i++) {
                if (statuses.indexOf(statusSelect.options[i].value) < currentStatusIndex) {
                    statusSelect.options[i].disabled = true;
                } else {
                    statusSelect.options[i].disabled = false;
                }
            }

            // Đặt URL cho form cập nhật
            form.action = '/admin/bookings/update/' + bookingId;

            submitBtn.disabled = true;
        });

        statusSelect.addEventListener('change', function () {
            if (statusSelect.value) {
                submitBtn.disabled = false; 
            } else {
                submitBtn.disabled = true; 
            }
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.form-delete');

        deleteForms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const status = this.querySelector('input[name="status"]').value;

                if (status !== 'completed' && status !== 'cancelled') {
                    Swal.fire({
                        title: "Xác nhận hủy?",
                        text: "Nếu hủy bạn sẽ không thể khôi phục!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Đồng ý',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                } 
            });
        });
    });
</script>
@endsection
