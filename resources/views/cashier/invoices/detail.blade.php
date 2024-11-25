@extends('layouts.cashier')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light d-print-none">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Hóa đơn</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('cashier.invoices.index') }}" style="color: inherit;">Hóa đơn</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Chi tiết hóa đơn</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content content-boxed">
        <!-- Invoice -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">#{{ $invoice->code }}</h3>
                <div class="block-options">
                    <!-- Print Page functionality is initialized dmPrint() -->
                    <button type="button" class="btn-block-option" onclick="Dashmix.helpers('dm-print');">
                        <i class="si si-printer me-1"></i> In hóa đơn
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="p-sm-2 p-xl-5">
                    <!-- Invoice Info -->
                    <div class="row mb-2">
                        <!-- Company Info -->
                        <div class="col-6">
                            <p class="h3">Cửa hàng</p>
                            <address>
                                {{ $invoice->store->name }}<br>
                                {{ $invoice->store->address }}<br>
                                SĐT: {{ $invoice->store->phone }}<br>
                                NV: {{ $invoice->staff->name }}<br>
                                Date: {{ $invoice->created_at->format('H:i d/m/Y') }}
                            </address>
                        </div>
                        <!-- END Company Info -->

                        <!-- Client Info -->
                        <div class="col-6 text-end">
                            <p class="h3">Khách hàng</p>
                            <address>
                                {{ $invoice->name }}<br>
                                SĐT: {{ $invoice->store->phone }}<br>
                                PT: {{ $invoice->payment_method == 'cash' ? 'Tiền mặt' : 'Chuyển khoản' }}
                            </address>
                        </div>
                        <!-- END Client Info -->
                    </div>
                    <!-- END Invoice Info -->

                    <!-- Table -->
                    <div class="table-responsive push">
                        <table class="table table-bordered">
                            <thead class="bg-body">
                                <tr>
                                    <th class="text-center" style="width: 60px;">STT</th>
                                    <th>Dịch vụ</th>
                                    <th class="text-center" style="width: 120px;">Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoiceDetails as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <p class="fw-semibold mb-1">{{ $item->service->name }}</p>
                                        </td>

                                        <td class="text-end">{{ number_format($item->price, 0, ',', '.') . ' đ' }}</td>
                                        
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="fw-semibold text-end">Thành tiền</td>
                                    <td class="fw-bold text-end bg-body-light">{{ number_format($invoice->total_amount, 0, ',', '.') . ' đ' }}</td>
                                  </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- END Table -->

                    <!-- Footer -->
                    <p class="text-muted text-center my-1">
                        Cảm ơn bạn đã sử dụng dịch vụ.
                    </p>
                    <!-- END Footer -->
                </div>
            </div>
        </div>
        <!-- END Invoice -->
    </div>
@endsection
