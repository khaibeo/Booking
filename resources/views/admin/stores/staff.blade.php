@extends('layouts.backend')

@section('css')
    <style>
        img {
            width: 3.125rem;
            height: 3.125rem;
        }
    </style>
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Danh sách nhân viên</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @if (isset($staffs[0]))
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.stores.edit', $staffs[0]->store_id) }}" style="color: inherit;">Cửa
                                    hàng</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">Danh sách nhân viên</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="content">
        <div class="mb-3 ">
            <a href="{{ route('admin.stores.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="block block-rounded">
            <form action="" class="row block-header d-flex" method="GET">
                <div class="col-md-6 d-flex gap-2">
                    <input id="name" class="form-control mt-2" value="{{ request('name') }}" type="text"
                        name="name" placeholder="Tìm kiếm theo tên nhân viên">
                        <button class="d-block mt-2 btn btn-primary">Lọc</button>
                </div>
            </form>
            <div class="block-header block-header-default">
                <h3 class="block-title">Danh sách nhân viên</h3>
            </div>
            <div class="block-content">
                @if ($staffs->count() > 0)
                    <table class="table table-hover" id="usersTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th></th>
                                <th>Tên</th>
                                <th class="d-none d-sm-table-cell">Vai trò</th>
                                <th class="d-none d-sm-table-cell">Số điện thoại</th>
                                <th class="d-none d-sm-table-cell">Email</th>
                                <th class="d-none d-sm-table-cell">Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffs as $item)
                                @php
                                    $path = '';
                                    if ($item->image) {
                                        $path = \Storage::url($item->image->path);
                                    }
                                @endphp
                                <tr class="align-middle">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td><img class="img object-fit-fill rounded-3" src="{{ $path }}" alt=""></td>
                                    <td class="fw-semibold">{{ $item->name }}</td>
                                    <td class="d-none d-sm-table-cell">{{ ucfirst($item->role) }}</td>
                                    <td class="d-none d-sm-table-cell">{{ $item->phone }}</td>
                                    <td class="d-none d-sm-table-cell">{{ $item->email }}</td>
                                    <td class="d-none d-sm-table-cell">{{ $item->created_at->format('H:i d-m-Y') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            {{-- EDIT --}}
                                            <a href="{{ route('admin.users.edit', $item) }}" type="button"
                                                class="btn btn-sm btn-alt-warning mx-2" data-bs-toggle="tooltip"
                                                title="Chỉnh sửa">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>

                                            {{-- DELETE  --}}
                                            <form action="{{ route('admin.users.destroy', $item) }}" class="form-delete"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-alt-danger"
                                                    data-bs-toggle="tooltip" title="Xóa">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $staffs->links() }}
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center p-5">
                        <p class="m-0 p-5">Không tìm thấy nhân viên</p>
                    </div>
                @endif
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