@extends('layouts.cashier')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Danh sách hóa đơn</h1>
                <a href="{{ route('cashier.invoices.create') }}" class="d-block btn btn-alt-primary my-2">
                    <i class="fa fa-fw fa-plus me-1"></i> Tạo hóa đơn
                  </a>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="content">
        <div class="block block-rounded">
            <form action="{{ route('cashier.invoices.index') }}" class="row block-header align-items-end" method="GET">
                <div class="col-lg-3">
                    <label for="id">Mã hóa đơn</label>
                    <input id="id" class="form-control mt-2" value="{{ request('code') }}" type="text"
                        name="code" placeholder="Tìm kiếm theo mã hóa đơn">
                </div>

                <div class="col-lg-3">
                    <label for="date">Từ ngày</label>
                    <input id="date" class="form-control mt-2" value="{{ request('start_date') }}" type="date"
                        name="start_date" placeholder="Tìm kiếm theo ngày">
                </div>

                <div class="col-lg-3">
                    <label for="date">Đến ngày</label>
                    <input id="date" class="form-control mt-2" value="{{ request('end_date') }}" type="date"
                        name="end_date" placeholder="Tìm kiếm theo ngày">
                </div>

                <div class="col-lg-3">
                    <button class="d-block mt-2 btn btn-primary">Lọc</button>
                </div>
            </form>

            <div class="block-header block-header-default">
                <h3 class="block-title">Danh sách hóa đơn</h3>
                <div class="block-options">
                    <div class="block-options-item">
                        <a href="{{ route('cashier.invoices.create') }}" class="btn btn-sm btn-alt-primary"
                            data-bs-toggle="tooltip" title="Tạo hóa đơn"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="block-content">
                @if ($invoices->count() > 0)
                    <table class="table table-hover" id="invoicesTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">STT</th>
                                <th>Mã hóa đơn</th>
                                <th class="d-none d-sm-table-cell text-end">Tổng tiền</th>
                                <th class="d-none d-sm-table-cell">Ngày tạo</th>
                                <th class="text-center" style="width: 100px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $item)
                                <tr class="align-middle">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="fw-semibold">{{ $item->code }}</td>
                                    <td class="d-none d-sm-table-cell text-end">{{ number_format($item->total_amount,0,',','.') . 'đ' }}</td>
                                    <td class="d-none d-sm-table-cell">{{ $item->created_at->format('H:i d-m-Y') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            {{-- DETAIl --}}
                                            <a href="{{ route('cashier.invoices.detail', $item) }}" type="button"
                                                class="btn btn-sm btn-alt-warning mx-2" data-bs-toggle="tooltip"
                                                title="Xem chi tiết">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            {{-- DELETE  --}}
                                            <form action="{{ route('cashier.invoices.destroy', $item) }}" class="form-delete"
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
                        {{ $invoices->links() }}
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center p-5">
                        <p class="m-0 p-5">Không tìm thấy hóa đơn</p>
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
