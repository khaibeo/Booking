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
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Danh sách danh mục</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.services_category.index') }}" style="color: inherit;">Danh mục</a>
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
            <div class="block-content">
                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('admin.services_category.create') }}" class="btn btn-primary">Thêm mới</a>
                @endif
            </div>  

            <div class="block-content">
                <table class="table table-hover" id="bookingsTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Tên danh mục</th>
                            <th class="d-none d-sm-table-cell">Ngày tạo</th>
                            @if (auth()->user()->role == 'admin')
                                <th class="text-center" style="width: 100px;">Tùy chọn</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($serviceCategories as $serviceCategory)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="d-none d-sm-table-cell">{{ $serviceCategory->name }}</td>
                                <td class="d-none d-sm-table-cell">
                                    {{ \Carbon\Carbon::parse($serviceCategory->created_at)->format('d-m-Y') }}</td>
                                @if (auth()->user()->role == 'admin')
                                    <td class="d-none d-sm-table-cell table-cell-store">
                                        <div class="btn-group">
                                            <!-- Cập nhật trạng thái -->
                                            <a href="{{ route('admin.services_category.edit', $serviceCategory->id) }}"
                                                class="btn btn-sm btn-alt-warning mx-2 d-flex align-items-center"
                                                style="height: 30px; line-height: 30px;" title="Chỉnh sửa">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            <form
                                                action="{{ route('admin.services_category.destroy', $serviceCategory->id) }}"
                                                method="post" class="form-delete">
                                                @method('delete')
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-sm btn-alt-danger mx-2 d-flex align-items-center"
                                                    style="height: 30px; line-height: 30px;" title="Xóa">
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
            </div>
        </div>
    </div>
@endsection

@section('js')
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

