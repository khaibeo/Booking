@extends('layouts.backend')

@section('css')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Thêm mới cửa hàng</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.stores.index') }}" style="color: inherit;">Cửa hàng</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm mới cửa hàng</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content">
                <form action="{{ route('admin.stores.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h2 class="content-heading pt-0">Thêm mới cửa hàng</h2>

                    <div class="row">
                        <div class="col-lg-12 col-xl-8 offset-xl-2">
                            <!-- Tên cửa hàng -->
                            <div class="mb-4">
                                <label class="form-label" for="name">Tên cửa hàng</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Nhập tên cửa hàng">
                                @error('name')
                                    <div class="text-danger mt-2" id="name-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="code">Mã cửa hàng</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    id="code" name="code" value="{{ old('code') }}"
                                    placeholder="Nhập mã cửa hàng">
                                @error('code')
                                    <div class="text-danger mt-2" id="name-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Địa chỉ -->
                            <div class="mb-4">
                                <label class="form-label" for="address">Địa chỉ</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" value="{{ old('address') }}"
                                    placeholder="Nhập địa chỉ cửa hàng">
                                @error('address')
                                    <div class="text-danger mt-2" id="address-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Địa chỉ bản đồ -->
                            <div class="mb-4">
                                <label class="form-label" for="map">Đường dẫn bản đồ</label>
                                <input type="url" class="form-control @error('link_map') is-invalid @enderror"
                                    id="map" name="link_map" value="{{ old('link_map') }}"
                                    placeholder="Nhập đường dẫn Google Maps">
                                @error('link_map')
                                    <div class="text-danger mt-2" id="map-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Số điện thoại -->
                            <div class="mb-4">
                                <label class="form-label" for="phone">Số điện thoại</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}"
                                    placeholder="Nhập số điện thoại cửa hàng">
                                @error('phone')
                                    <div class="text-danger mt-2" id="phone-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ảnh đại diện -->
                            <div class="mb-4">
                                <label class="form-label" for="image">Ảnh đại diện</label>
                                <div id="my-dropzone" class="dropzone"></div>
                                <input type="hidden" name="image_id" id="uploadedImage" value="">
                                @error('image_id')
                                    <div class="text-danger mt-2" id="image-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mô tả -->
                            <div class="mb-4">
                                <label class="form-label" for="description">Mô tả</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" placeholder="Nhập mô tả cửa hàng">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger mt-2" id="description-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mb-4">Thêm cửa hàng</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        Dropzone.options.myDropzone = {
            url: "{{ route('upload') }}",
            maxFiles: 1,
            maxFilesize: 2,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            paramName: "file",
            dictDefaultMessage: "Kéo thả ảnh vào đây hoặc nhấp để chọn ảnh",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });

                this.on("success", function(file, response) {
                    document.getElementById("uploadedImage").value = response.image_id;
                });

                this.on("error", function(file, errorMessage) {
                    console.log(errorMessage);
                });

                this.on("removedfile", function(file) {
                    document.getElementById("uploadedImage").value = '';
                });
            }
        };
        document.addEventListener('DOMContentLoaded', function() {
            const fields = ['name','code', 'address', 'map', 'phone', 'image', 'description'];

            fields.forEach(function(field) {
                const inputElement = document.getElementById(field);
                const errorElement = document.getElementById(`${field}-error`);

                if (inputElement) {
                    inputElement.addEventListener('input', function() {

                        if (inputElement.classList.contains('is-invalid')) {
                            inputElement.classList.remove('is-invalid');
                        }


                        if (errorElement) {
                            errorElement.style.display = 'none';
                        }
                    });
                }
            });
        });
    </script>
@endsection
