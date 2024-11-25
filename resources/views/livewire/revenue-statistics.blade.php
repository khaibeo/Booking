<div class="col-md-8">
    <!--  Latest Orders -->
    <div class="block block-rounded block-mode-loading-refresh">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Thống kê doanh thu
            </h3>
        </div>

        <div class="block-content">
            <div class="row">
                <div class="col-lg-3">
                    <div>
                        <label for="startDate" class="block mb-2">Từ ngày:</label>
                        <input type="date" wire:model="startDate" id="startDate" class="form-control">
                    </div>
                </div>

                <div class="col-lg-3">
                    <div>
                        <label for="endDate" class="block mb-2">Đến ngày:</label>
                        <input type="date" wire:model="endDate" id="endDate" class="form-control">
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="mb-4">
                        <label for="dateRange" class="block mb-2">Thời gian:</label>
                        <select wire:model="dateRange" id="dateRange" class="form-select">
                            <option value="day">Ngày</option>
                            <option value="week">Tuần</option>
                            <option value="month">Tháng</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <button wire:click="getStatisticsProperty" class="btn btn-primary mt-4 p-2 rounded">
                        Thống kê
                    </button>
                </div>

            </div>
        </div>

        <div class="block-content">
            @if ($statistics->count() > 0)
                <table class="table table-striped table-hover table-borderless table-vcenter fs-sm">
                    <thead>
                        <tr class="text-uppercase">
                            <th class="d-xl-table-cells">Thời gian</th>
                            <th class="d-none d-xl-table-cell">Số hóa đơn</th>
                            <th class="d-none d-xl-table-cell">Doanh thu</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($statistics as $stat)
                            <tr>
                                <td class="d-none d-xl-table-cell">
                                    <span class="d-none d-sm-table-cell fw-medium">
                                        @if ($dateRange === 'day')
                                            {{ date($stat->date) }}
                                        @elseif ($dateRange === 'week')
                                            Tuần {{ substr($stat->week, -2) }} của năm {{ $stat->year }}
                                        @elseif ($dateRange === 'month')
                                            Tháng {{ $stat->month }}/{{ $stat->year }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-warning">{{ $stat->invoice_count }}</span>
                                </td>
                                <td class="d-none d-sm-table-cell fw-medium">
                                    {{ number_format($stat->revenue, 0, ',', '.') }} đ
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $statistics->links() }}
                </div>
            @else
                <p class="mt-3 text-center">Không có dữ liệu thống kê trong khoảng thời gian đã chọn.</p>
            @endif
        </div>
    </div>
</div>
