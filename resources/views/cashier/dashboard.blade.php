@extends('layouts.cashier')

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
        <!-- Overview -->
        <div class="row items-push">
            <div class="col-sm-6 col-xl-3">
                <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1">
                        <div class="item rounded-3 bg-body mx-auto my-3">
                            <i class="fa fa-users fa-lg text-primary"></i>
                        </div>
                        <div class="fs-1 fw-bold">{{ $bookingCount }}</div>
                        <div class="text-muted mb-3">Lịch đặt trong ngày</div>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                        <a class="fw-medium" href="{{ route('cashier.bookings.index') }}">
                            Xem chi tiết
                            <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1">
                        <div class="item rounded-3 bg-body mx-auto my-3">
                            <i class="fa fa-users fa-lg text-primary"></i>
                        </div>
                        <div class="fs-1 fw-bold">{{ $invoiceCount }}</div>
                        <div class="text-muted mb-3">Hóa đơn trong ngày</div>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                        <a class="fw-medium" href="{{ route('cashier.invoices.index') . '?date=' . date('Y-m-d') }}">
                            Xem chi tiết
                            <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1">
                        <div class="item rounded-3 bg-body mx-auto my-3">
                            <i class="fa fa-users fa-lg text-primary"></i>
                        </div>
                        <div class="fs-1 fw-bold">{{ $serviceCount }}</div>
                        <div class="text-muted mb-3">Dịch vụ sử dụng</div>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                        <a class="fw-medium" href="{{ route('cashier.report.index') }}">
                            Xem chi tiết
                            <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1">
                        <div class="item rounded-3 bg-body mx-auto my-3">
                            <i class="fa fa-wallet fa-lg text-primary"></i>
                        </div>
                        <div class="fs-1 fw-bold">{{ number_format($totalRevenue, 0) . ' đ' }}</div>
                        <div class="text-muted mb-3">Doanh thu trong ngày</div>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                        <a class="fw-medium" href="{{ route('cashier.report.index') }}">
                            Xem báo cáo
                            <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                        </a>
                    </div>
                </div>
            </div>
            {{-- <div class="col-sm-6 col-xl-3">
        <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
          <div class="block-content block-content-full flex-grow-1">
            <div class="item rounded-3 bg-body mx-auto my-3">
              <i class="fa fa-chart-line fa-lg text-primary"></i>
            </div>
            <div class="fs-1 fw-bold">386</div>
            <div class="text-muted mb-3">Confirmed Sales</div>
            <div class="d-inline-block px-3 py-1 rounded-pill fs-sm fw-semibold text-success bg-success-light">
              <i class="fa fa-caret-up me-1"></i>
              7.9%
            </div>
          </div>
          <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
            <a class="fw-medium" href="javascript:void(0)">
              View all sales
              <i class="fa fa-arrow-right ms-1 opacity-25"></i>
            </a>
          </div>
        </div>
      </div> --}}
            {{-- <div class="col-sm-6 col-xl-3">
        <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
          <div class="block-content block-content-full">
            <div class="item rounded-3 bg-body mx-auto my-3">
              <i class="fa fa-wallet fa-lg text-primary"></i>
            </div>
            <div class="fs-1 fw-bold">$4,920</div>
            <div class="text-muted mb-3">Total Earnings</div>
            <div class="d-inline-block px-3 py-1 rounded-pill fs-sm fw-semibold text-danger bg-danger-light">
              <i class="fa fa-caret-down me-1"></i>
              0.3%
            </div>
          </div>
          <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
            <a class="fw-medium" href="javascript:void(0)">
              Withdrawal options
              <i class="fa fa-arrow-right ms-1 opacity-25"></i>
            </a>
          </div>
        </div>
      </div> --}}
        </div>
        <!-- END Overview -->

        <!-- Store Growth -->
        {{-- <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">
          Store Growth
        </h3>
        <div class="block-options">
          <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
            <i class="si si-refresh"></i>
          </button>
          <button type="button" class="btn-block-option">
            <i class="si si-wrench"></i>
          </button>
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="row">
          <div class="col-md-5 col-xl-4 d-md-flex align-items-md-center">
            <div class="p-md-2 p-lg-3">
              <div class="py-3">
                <div class="fs-1 fw-bold">1,430</div>
                <div class="fw-semibold">Your new website Customers</div>
                <div class="py-3 d-flex align-items-center">
                  <div class="bg-success-light p-2 rounded me-3">
                    <i class="fa fa-fw fa-arrow-up text-success"></i>
                  </div>
                  <p class="mb-0">
                    You have a <span class="fw-semibold text-success">12% customer growth</span> in the last 30 days. This is amazing, keep it up!
                  </p>
                </div>
              </div>
              <div class="py-3">
                <div class="fs-1 fw-bold">65</div>
                <div class="fw-semibold">New products added</div>
                <div class="py-3 d-flex align-items-center">
                  <div class="bg-success-light p-2 rounded me-3">
                    <i class="fa fa-fw fa-arrow-up text-success"></i>
                  </div>
                  <p class="mb-0">
                    You’ve managed to add <span class="fw-semibold text-success">12% more products</span> in the last 30 days. Store’s portfolio is growing!
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-7 col-xl-8 d-md-flex align-items-md-center">
            <div class="p-md-2 p-lg-3 w-100" style="height: 450px;">
              <!-- Bars Chart Container -->
              <!-- Chart.js Chart is initialized in js/pages/be_pages_dashboard.min.js which was auto compiled from _js/pages/be_pages_dashboard.js -->
              <!-- For more info and examples you can check out http://www.chartjs.org/docs/ -->
              <canvas id="js-chartjs-analytics-bars"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
        <!-- END Store Growth -->

        <!-- Latest Orders + Stats -->
        <div class="row">
            <div class="col-md-12">
                <!--  Latest Orders -->
                <div class="block block-rounded block-mode-loading-refresh">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Hóa đơn gần đây
                        </h3>
                    </div>
                    <div class="block-content">
                        <table class="table table-striped table-hover table-borderless table-vcenter fs-sm">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>STT</th>
                                    <th>Mã hóa đơn</th>
                                    <th class="d-xl-table-cells">Tổng tiền</th>
                                    <th class="d-none d-xl-table-cell">Phương thức</th>
                                    <th class="d-none d-xl-table-cell">Ngày</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latestInvoices as $item)
                                    <tr>
                                        <td>
                                            <span>{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">{{ $item->code }}</span>
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            <span
                                                class="fs-sm text-muted text-end fw-medium">{{ number_format($item->total_amount, 0, ',', '.') . 'đ' }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="fw-semibold text-warning">{{ $item->payment_method == 'cash' ? 'Tiền mặt' : 'Chuyển khoản' }}</span>
                                        </td>
                                        <td class="d-none d-sm-table-cell fw-medium">
                                            {{ $item->created_at->format('H:i d-m-Y') }}
                                        </td>
                                        <td class="text-center text-nowrap fw-medium">
                                            <a href="{{ route('cashier.invoices.detail', $item) }}">
                                                Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light fs-sm text-center">
                        <a class="fw-medium" href="{{ route('cashier.invoices.index') }}">
                            Xem tất cả hóa đơn
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
