@extends('layouts.backend')
@section('content')
    <base href="/">

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Danh sách ngày mở cửa</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.stores.edit', $storeId->id) }}" style="color: inherit;">Cửa
                                hàng</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Ngày mở cửa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Danh sách ngày mở cửa</h3>
                <a class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#modal-block-large">
                    <i class="fa fa-fw fa-plus opacity-50"></i>
                    <span class="d-none d-sm-inline ms-1">Thêm lịch mở cửa</span>
                </a>
            </div>
            <div class="modal" id="modal-block-large" tabindex="-1" role="dialog" aria-labelledby="modal-block-large"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Thêm ngày mở cửa</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <form action="{{ route('admin.add-opening-store', $storeId) }}" method="post">
                                @csrf

                                <div class="block-content mb-3">
                                    <div class="form-group mb-3">
                                        <label for="date" class="mb-2">Ngày bắt đầu </label>
                                        <input type="date" class="form-control" name="date" id="date">
                                        @error('date')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="date" class="mb-2">Ngày kết thúc </label>
                                        <input type="date" class="form-control" name="end_date" id="date">
                                        @error('end_date')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="opening_time" class="mb-2">Giờ mở cửa</label>
                                        <input type="time" class="form-control" name="opening_time" id="opening_time">
                                        @error('opening_time')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="closing_time" class="mb-2">Giờ đóng cửa</label>
                                        <input type="time" class="form-control" name="closing_time" id="closing_time">
                                        @error('closing_time')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="block-content block-content-full text-end bg-body">
                                    <button type="button" class="btn btn-sm btn-alt-secondary"
                                        data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-sm btn-alt-primary">Thêm mới</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content">
                @if ($getOpeningStore->count() > 0)
                    <div class="row items-push">
                        @foreach ($getOpeningStore as $item)
                            <div class="col-md-6 col-xl-4">
                                <div class="block block-rounded h-100 mb-0 bg-body-light">
                                    <div class="block-header">
                                        <div class="flex-grow-1 d-flex text-muted fs-sm fw-semibold">
                                            <i class="fa fa-calendar-check me-1"></i>
                                            {{ $item->date ? \Carbon\Carbon::parse($item->date)->format('d-m/Y') : '' }} -
                                            {{ $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('d-m/Y') : '' ?? '' }}
                                        </div>

                                        <div class="block-options">
                                            <div class="dropdown">
                                                <button type="button" class="btn-block-option" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <form
                                                        action="{{ route('admin.delete-opening-store', [$item->store_id, $item->id]) }}"
                                                        method="post" class="form-delete">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fa fa-fw fa-bell me-1"></i> Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block-content bg-body-light text-center">
                                        <h4 class="fs-6 text-muted mb-3"><strong>Mở cửa:</strong>
                                            {{ $item->opening_time }}
                                        </h4>
                                        <h4 class="fs-6 text-muted mb-3"><strong>Đóng cửa:</strong>
                                            {{ $item->closing_time }}
                                        </h4>
                                    </div>

                                    <div class="block-content block-content-full">
                                        <div class="row g-sm">
                                            <div class="col-6">
                                                <button data-bs-toggle="modal"
                                                    data-bs-target="#modal-block-large-show-opening-store{{ $item->id }}"
                                                    class="btn w-100 btn-alt-secondary">
                                                    <i class="fa fa-eye me-1 opacity-50"></i> Chi tiết
                                                </button>
                                            </div>

                                            @if (\Carbon\Carbon::parse($item->date)->gte(\Carbon\Carbon::today()))
                                                <div class="col-6">
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#modal-block-large-update-opening-store{{ $item->id }}"
                                                        class="btn w-100 btn-alt-secondary">
                                                        <i class="fa fa-archive me-1 opacity-50"></i> Chỉnh sửa
                                                    </button>
                                                </div>
                                            @else
                                                <div class="col-6">
                                                    <button title="Không thể cập nhật ngày đã qua" type="button"
                                                        class="js-notify btn w-100 btn-alt-secondary push">
                                                        <i class="fa fa-archive me-1 opacity-50"></i> Chỉnh sửa
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- END Project #1 -->
                            </div>
                        @endforeach

                        @foreach ($getOpeningStore as $item)
                            <div class="modal" id="modal-block-large-show-opening-store{{ $item->id }}"
                                tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="block block-rounded block-themed block-transparent mb-0">
                                            <div class="block-header bg-primary-dark">
                                                <h3 class="block-title">Chi tiết</h3>
                                                <div class="block-options">
                                                    <button type="button" class="btn-block-option"
                                                        data-bs-dismiss="modal" aria-label="Close">
                                                        <i class="fa fa-fw fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <form action="" method="post">
                                                <div class="block-content mb-3">
                                                    <div class="form-group mb-3">
                                                        <label for="date" class="mb-2">Ngày mở cửa</label>
                                                        <input type="date" class="form-control" disabled
                                                            value={{ $item->date }} name="date" id="date">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label for="opening_time" class="mb-2">Giờ mở cửa</label>
                                                        <input type="time" class="form-control" disabled
                                                            name="opening_time" id="opening_time"
                                                            value="{{ $item->opening_time }}">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="closing_time" class="mb-2">Giờ đóng cửa</label>
                                                        <input type="time" class="form-control" disabled
                                                            name="closing_time" id="closing_time"
                                                            value="{{ $item->closing_time }}">
                                                    </div>
                                                </div>
                                                <div class="block-content block-content-full text-end bg-body">
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal" id="modal-block-large-update-opening-store{{ $item->id }}"
                                tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="block block-rounded block-themed block-transparent mb-0">
                                            <div class="block-header bg-primary-dark">
                                                <h3 class="block-title">Cập nhật </h3>
                                                <div class="block-options">
                                                    <button type="button" class="btn-block-option"
                                                        data-bs-dismiss="modal" aria-label="Close">
                                                        <i class="fa fa-fw fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <form
                                                action="{{ route('admin.update-opening-store', [$item->store_id, $item->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="block-content mb-3">
                                                    <div class="form-group mb-3">
                                                        <label for="date" class="mb-2">Ngày mở cửa </label>
                                                        <input type="date" class="form-control"
                                                            value={{ $item->date }} name="date" id="date">
                                                        @error('date')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="form-group mb-3" hidden>
                                                        <label for="date" class="mb-2">Ngày mở cửa</label>
                                                        <input type="date" class="form-control" name="date"
                                                            value="{{ $item->date }}" id="date">
                                                    </div>
                                                    <div class="form-group mb-3" hidden>
                                                        <label for="date" class="mb-2">Ngày đóng cửa</label>
                                                        <input type="date" class="form-control" name="date"
                                                            value="{{ $item->date }}" id="date">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="opening_time" class="mb-2">Giờ mở cửa</label>
                                                        <input type="time" class="form-control" name="opening_time"
                                                            value="{{ \Carbon\Carbon::parse($item->opening_time)->format('H:i') }}"
                                                            id="opening_time">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="closing_time" class="mb-2">Giờ đóng cửa</label>
                                                        <input type="time" class="form-control" name="closing_time"
                                                            value="{{ \Carbon\Carbon::parse($item->closing_time)->format('H:i') }}"
                                                            id="closing_time">
                                                    </div>
                                                </div>
                                                <div class="block-content block-content-full text-end bg-body">
                                                    <button type="button" class="btn btn-sm btn-alt-secondary"
                                                        data-bs-dismiss="modal">Hủy</button>
                                                    <button type="submit" class="btn btn-sm btn-primary"
                                                        data-bs-dismiss="modal">Cập nhật</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center p-5">
                        <p class="m-0 p-5">Không có lịch mở cửa</p>
                    </div>
                @endif
                <div class="block-options mb-5">
                    <a href="{{ route('admin.stores.index') }}" class="btn btn-alt-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
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
