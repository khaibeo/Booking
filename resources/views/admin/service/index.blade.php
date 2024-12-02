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
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Danh sách dịch vụ</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.services.index') }}" style="color: inherit;">Dịch vụ</a>
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
            {{-- <div class="block-header block-header-default">
                <h3 class="block-title">Danh sách dịch vụ</h3>
                <div class="block-options">
                    <div class="block-options-item">
                    </div>
                </div>
            </div> --}}

            @if (auth()->user()->role == 'admin')
                <div class="block-content">
                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">Thêm mới</a>
                </div>
            @endif

            <div class="block-content">
                <table class="table table-hover" id="servicesTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Tên dịch vụ</th>
                            <th class="d-none d-sm-table-cell">Danh mục</th>
                            <th class="d-none d-sm-table-cell">Giá</th>
                            <th class="d-none d-sm-table-cell">Thời gian</th>
                            @if (auth()->user()->role == 'admin')
                                <th class="text-center" style="width: 100px;">Tùy chọn</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="d-none d-sm-table-cell">{{ $service->name }}</td>
                                <td class="d-none d-sm-table-cell">{{ $service->category['name'] }}</td>
                                <td class="d-none d-sm-table-cell">{{ number_format($service->price, 0, ',', '.') }} đ
                                </td>
                                <td class="d-none d-sm-table-cell">{{ $service->duration }} phút </td>

                                @if (auth()->user()->role == 'admin')
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <!-- Cập nhật trạng thái -->
                                            <a type="button"
                                                class="btn btn-sm btn-alt-warning mx-2 d-flex align-items-center"
                                                style="height: 30px; line-height: 30px;"
                                                href="{{ route('admin.services.edit', $service->id) }}" title="Chỉnh sửa">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('admin.services.destroy', $service->id) }}"
                                                method="post" class="form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-alt-danger mx-2 d-flex align-items-center"
                                                    style="height: 30px; line-height: 30px;" title="Chỉnh sửa">
                                                    <i class="far fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>{{ $services->links() }}</div>
            </div>
        </div>
    </div>
@endsection

<!-- Modal Cập Nhật Trạng Thái -->

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var updateStatusModal = document.getElementById('updateStatusModal');
            var statusSelect = document.getElementById('statusSelect');
            var submitBtn = document.querySelector('.modal-footer .btn-primary');
            var form = document.getElementById('updateStatusForm');

            updateStatusModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var serviceId = button.getAttribute('data-id');
                var serviceStatus = button.getAttribute('data-status');

                var serviceIdInput = document.getElementById('serviceId');

                serviceIdInput.value = serviceId;
                statusSelect.value = serviceStatus;

                var statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
                var currentStatusIndex = statuses.indexOf(serviceStatus);

                for (var i = 0; i < statusSelect.options.length; i++) {
                    if (statuses.indexOf(statusSelect.options[i].value) < currentStatusIndex) {
                        statusSelect.options[i].disabled = true;
                    } else {
                        statusSelect.options[i].disabled = false;
                    }
                }

                // Đặt URL cho form cập nhật
                form.action = '/admin/services/update/' + serviceId;

                submitBtn.disabled = true;
            });

            statusSelect.addEventListener('change', function() {
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
            const deleteBtns = document.querySelectorAll('.form-delete');

            for (const btn of deleteBtns) {
                btn.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: "Xác nhận xóa?",
                        text: "Nếu xóa bạn sẽ không thể khôi phục!",
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
                });
            }
        });
    </script>
@endsection
