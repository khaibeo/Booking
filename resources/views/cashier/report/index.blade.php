@extends('layouts.cashier')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Quick Overview -->
        <div class="row items-push">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center h-100 mb-0"
                    href="{{ route('cashier.invoices.index') }}">
                    <div class="block-content py-5">
                        <div class="fs-3 fw-semibold text-primary mb-1">{{ $invoiceCount }}</div>
                        <p class="fw-semibold fs-sm text-muted text-uppercase mb-0">
                            Hóa đơn
                        </p>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center h-100 mb-0" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="fs-3 fw-semibold mb-1">{{ number_format($totalRevenue, 0, ',', '.') . ' đ' }}</div>
                        <p class="fw-semibold fs-sm text-muted text-uppercase mb-0">
                            Tổng doanh thu
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->

        <!-- Orders Overview -->
        {{-- <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Orders Overview</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle"
                        data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <!-- Chart.js is initialized in js/pages/be_pages_ecom_dashboard.min.js which was auto compiled from _js/pages/be_pages_ecom_dashboard.js) -->
                <!-- For more info and examples you can check out http://www.chartjs.org/docs/ -->
                <canvas id="js-chartjs-overview" style="height: 420px;"></canvas>
            </div>
        </div> --}}
        <!-- END Orders Overview -->
        <div class="row">
            @livewire('revenue-statistics')

            <div class="col-xl-4">
                <!-- Latest Orders -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Top dịch vụ</h3>
                    </div>
                    <div class="block-content">
                        <table class="table table-borderless table-striped table-vcenter fs-sm">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Dịch vụ</th>
                                    <th>Lượt dùng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topServices as $item)
                                    <tr>
                                        <td class="fw-semibold" style="width: 100px;">
                                            <a href="#">{{ $loop->iteration }}</a>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <a class="fw-medium" href="#">{{ $item['name'] }}</a>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $item['total_sold'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END Latest Orders -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
