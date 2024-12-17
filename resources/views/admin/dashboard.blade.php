@extends('layouts.backend')

@section('content')
<!-- Hero -->
<div class="content">
  <div
    class="d-md-flex justify-content-md-between align-items-md-center py-3 pt-md-3 pb-md-0 text-center text-md-start">
    <div>
      <h1 class="h3 mb-1">
        Thông tin tổng hợp trong tháng
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
            <i class="fa fa-calendar-alt fa-3x text-primary"></i>
          </div>
          <div class="fs-1 fw-bold">{{ $bookingCount }}</div>
          <div class="text-muted mb-3">Tổng số lịch đặt</div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
        <div class="block-content block-content-full flex-grow-1">
          <div class="item rounded-3 bg-body mx-auto my-3">
            <i class="fa fa-file-invoice fa-3x text-primary"></i>
          </div>
          <div class="fs-1 fw-bold">{{ $invoiceCount }}</div>
          <div class="text-muted mb-3">Tổng số hóa đơn</div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
        <div class="block-content block-content-full flex-grow-1">
          <div class="item rounded-3 bg-body mx-auto my-3">
            <i class="fa fa-handshake fa-3x text-primary"></i>
          </div>
          <div class="fs-1 fw-bold">{{ $serviceCount }}</div>
          <div class="text-muted mb-3">Dịch vụ sử dụng</div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
        <div class="block-content block-content-full flex-grow-1">
          <div class="item rounded-3 bg-body mx-auto my-3">
            <i class="fa fa-wallet fa-3x text-primary"></i>
          </div>
          <div class="fs-1 fw-bold">{{ number_format($totalRevenue, 0) . ' đ' }}</div>
          <div class="text-muted mb-3">Tổng doanh thu</div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Overview -->
</div>
<div class="content">
  <h4>Doanh thu theo dịch vụ</h4>
  <!-- Biểu đồ cột -->
  <div class="d-flex justify-content-between">
    <canvas id="barChart" style="max-width: 600px; max-height: 600px;"></canvas>
    <!-- Biểu đồ tròn -->
    <canvas id="pieChart" style="max-width: 600px; max-height: 600px;"></canvas>
  </div>
  <div class="mt-5">
    <h4>Doanh thu hàng tháng và trung bình mỗi hóa đơn</h4>
    <div class="d-flex justify-content-center">
      <canvas id="revenueLineChart" style="max-width: 1200px; max-height: 600px;"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Cấu hình dữ liệu chung cho cả hai biểu đồ
  var labels = @json($serviceNames);
  var data = @json($revenues);
  var backgroundColors = [
    'rgba(255, 99, 132, 0.6)',
    'rgba(54, 162, 235, 0.6)',
    'rgba(255, 206, 86, 0.6)',
    'rgba(75, 192, 192, 0.6)',
    'rgba(153, 102, 255, 0.6)',
    'rgba(255, 159, 64, 0.6)'
  ];
  var borderColors = [
    'rgba(255, 99, 132, 1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)'
  ];

  // Biểu đồ cột
  var ctxBar = document.getElementById('barChart').getContext('2d');
  var barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Revenue',
        data: data,
        backgroundColor: backgroundColors,
        borderColor: borderColors,
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false // Tắt legend vì không cần cho biểu đồ cột
        },
        title: {
          display: true,
          text: 'Doanh thu theo dịch vụ (Bar Chart)'
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  // Biểu đồ tròn
  var ctxPie = document.getElementById('pieChart').getContext('2d');
  var pieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
      labels: labels,
      datasets: [{
        label: 'Revenue',
        data: data,
        backgroundColor: backgroundColors,
        borderColor: borderColors,
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'right' // Đặt legend ở bên phải cho biểu đồ tròn
        },
        title: {
          display: true,
          text: 'Doanh thu theo dịch vụ (Pie Chart)'
        }
      }
    }
  });

  // Line chart - Doanh thu theo 12 tháng gần nhất và doanh thu trung bình trên mỗi hóa đơn của 12 tháng gần nhất
  var ctx = document.getElementById('revenueLineChart').getContext('2d');
  var revenueLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: @json($monthlyLabels), // Nhãn tháng/năm
      datasets: [{
          label: 'Tổng doanh thu',
          data: @json($monthlyRevenues), // Tổng doanh thu theo tháng
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 2,
          fill: true // Tô màu dưới đường
        },
        {
          label: 'Doanh thu trung bình mỗi hóa đơn',
          data: @json($averagePerInvoice), // Doanh thu trung bình trên mỗi hóa đơn
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 2,
          fill: false // Không tô màu dưới đường
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Doanh thu hàng tháng và trung bình mỗi hóa đơn (12 tháng gần nhất)'
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Số tiền (VND)'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Tháng/Năm'
          }
        }
      }
    }
  });
</script>

<div class="content">

</div>
@endsection