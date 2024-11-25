@extends('layouts.cashier')

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Tạo hóa đơn</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('cashier.invoices.index') }}" style="color: inherit;">Hóa đơn</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tạo hóa đơn</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="content">
        <form id="invoice-form" action="{{ route('cashier.invoices.store') }}" method="POST">
            @csrf
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Dịch vụ sử dụng</h3>
                </div>
                <div class="block-content">
                    <div class="row">
                        <div class="col-lg-12 col-xl-8 offset-xl-2">
                            <div id="service-list" class="mb-4">
                                @foreach (old('services', []) as $service)
                                    <div class="product-item mb-3" data-service-id="{{ $service['id'] }}">
                                        <input type="hidden" name="services[{{ $service['id'] }}][id]"
                                            value="{{ $service['id'] }}">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="text" name="services[{{ $service['id'] }}][name]"
                                                    class="form-control" value="{{ $service['name'] }}" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" name="services[{{ $service['id'] }}][price]"
                                                    class="form-control service-price" value="{{ $service['price'] }}"
                                                    readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button"
                                                    class="btn btn-danger btn-sm remove-service">Xóa</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if ($booking)
                                    @foreach ($booking->details as $service)
                                        <div class="product-item mb-3" data-service-id="{{ $service->service_id }}">
                                            <input type="hidden" name="services[{{ $service->service_id }}][id]"
                                                value="{{ $service->service_id }}">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <input type="text" name="services[{{ $service->service_id }}][name]"
                                                        class="form-control" value="{{ $service->service->name }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number"
                                                        name="services[{{ $service->service_id }}][price]"
                                                        class="form-control service-price" value="{{ $service->price }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-service">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-9">
                                    <select id="service-select" class="form-select">
                                        <option value="">Chọn dịch vụ</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}" data-name="{{ $service->name }}"
                                                data-price="{{ $service->price }}">
                                                {{ $service->name }} - {{ number_format($service->price) }} VNĐ
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" id="add-service" class="btn btn-primary">Thêm dịch vụ</button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-3">
                                <p class="fw-bold">Tổng tiền: <span id="total-amount" class="text-danger">0 đ</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block block-rounded">
                <div class="block-content">
                    <h2 class="content-heading pt-0">Thông tin hóa đơn</h2>

                    <div class="row">
                        <div class="col-lg-12 col-xl-8 offset-xl-2">
                            <div class="mb-3">
                                <label class="form-label" for="name">Tên khách hàng</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $booking?->name) }}">
                                @error('name')
                                    <div class="text-danger mt-2" id="name-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phone">Số điện thoại</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $booking?->phone) }}">
                                @error('phone')
                                    <div class="text-danger mt-2" id="phone-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phone">Phương thức thanh toán</label>
                                <div class="d-flex gap-3">
                                    <label for="cash"><input id="cash" type="radio" name="payment_method"
                                            value="cash" {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }}>
                                        Tiền mặt</label>
                                    <label for="transfer"><input id="transfer" type="radio" name="payment_method"
                                            value="transfer" {{ old('payment_method') == 'transfer' ? 'checked' : '' }}>
                                        Chuyển khoản</label>
                                </div>

                                @error('payment_method')
                                    <div class="text-danger mt-2" id="phone-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('cashier.invoices.index') }}" class="btn btn-danger mb-3">Hủy giao
                                    dịch</a>
                                <button type="submit" class="btn btn-primary mb-3">Thanh toán</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#service-select').select2({
                placeholder: "Chọn một dịch vụ", // Tùy chọn placeholder
                allowClear: true // Cho phép xóa lựa chọn
            });

            const oldService = document.querySelectorAll('.product-item');

            for (const service of oldService) {
                let removeBtn = service.querySelector('.remove-service');
                removeBtn.addEventListener('click', () => removeProduct(service));
            }

            const serviceSelect = document.getElementById('service-select');
            const addServiceButton = document.getElementById('add-service');
            const serviceListContainer = document.getElementById('service-list');
            const totalAmountSpan = document.getElementById('total-amount');
            const invoiceForm = document.getElementById('invoice-form');

            addServiceButton.addEventListener('click', addService);
            invoiceForm.addEventListener('submit', submitForm);

            function addService() {
                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];

                if (selectedOption.value) {
                    const product = {
                        id: selectedOption.value,
                        name: selectedOption.dataset.name,
                        price: parseFloat(selectedOption.dataset.price)
                    };

                    const existingItem = serviceListContainer.querySelector(`[data-service-id="${product.id}"]`);
                    if (existingItem) {
                        Dashmix.helpers('jq-notify', {
                            type: 'warning',
                            icon: 'fa fa-exclamation-triangle me-1',
                            message: 'Dịch vụ này đã được thêm vào danh sách'
                        });
                    } else {
                        addServiceToList(product);
                    }
                    updateTotalAmount();
                    resetInputs();
                } else {
                    Dashmix.helpers('jq-notify', {
                        type: 'danger',
                        icon: 'fa fa-times me-1',
                        message: 'Vui lòng chọn dịch vụ'
                    });
                }
            }

            function addServiceToList(service) {
                const serviceItem = document.createElement('div');
                serviceItem.className = 'product-item mb-3';
                serviceItem.dataset.serviceId = service.id;
                serviceItem.innerHTML = `
                    <input type="hidden" name="services[${service.id}][id]" value="${service.id}">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" name="services[${service.id}][name]" class="form-control" value="${service.name}" readonly>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="services[${service.id}][price]" class="form-control service-price" value="${service.price}" readonly>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-service">Xóa</button>
                        </div>
                    </div>
                `;

                serviceListContainer.appendChild(serviceItem);

                let removeButton = serviceItem.querySelector('.remove-service');
                removeButton.addEventListener('click', () => removeProduct(serviceItem));
            }

            function removeProduct(serviceItem) {
                serviceItem.remove();
                updateTotalAmount();
            }

            function updateTotalAmount() {
                const priceInputs = document.querySelectorAll('.service-price');
                const total = Array.from(priceInputs).reduce((sum, input) => sum + parseFloat(input.value), 0);
                totalAmountSpan.textContent = formatCurrency(total);
            }

            function resetInputs() {
                serviceSelect.selectedIndex = 0;
            }

            function formatCurrency(amount) {
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(amount);
            }

            function submitForm(event) {
                event.preventDefault();
                this.submit();
            }

            updateTotalAmount();
        });
    </script>
@endsection
