@extends('layouts.cashier')

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
            <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Dịch vụ</h1>
            <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('cashier.services') }}" style="color: inherit;">Dịch vụ</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Danh sách</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
  <!-- END Hero -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Danh sách dịch vụ</h3>
            <div class="block-options">
                <div class="block-options-item">
                </div>
            </div>
        </div>

        <div class="block-content">
            <table class="table table-hover" id="servicesTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Tên dịch vụ</th>
                        <th>Danh mục</th>
                        <th class="d-none d-sm-table-cell">Thời gian</th>
                        <th class="d-none d-sm-table-cell">Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <td class="text-center">{{ $service->id }}</td>
                            <td class="d-none d-sm-table-cell">{{ $service->name }}</td>
                            <td class="d-none d-sm-table-cell">{{ $service->category->name }}</td>
                            <td class="d-none d-sm-table-cell">{{ $service->duration }} phút</td>
                            <td class="d-none d-sm-table-cell">{{ number_format($service->price,0,',','.') . ' đ' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>{{ $services->links() }}</div>
        </div>
    </div>
</div>
@endsection

