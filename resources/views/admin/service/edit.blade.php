@extends('layouts.backend');

@section('css')
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Cập nhật dịch vụ</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.services.index') }}" style="color: inherit;">Dịch vụ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Cập nhật dịch vụ</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content">
                <form action="{{ route('admin.services.update', $getServiceId->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <h2 class="content-heading pt-0">Cập nhật dịch vụ</h2>

                    <div class="row">
                        <div class="col-lg-12 col-xl-8 offset-xl-2">
                            <!-- Tên nhân viên -->
                            <div class="mb-4">
                                <label class="form-label" for="name">Tên dịch vụ</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ $getServiceId->name }}"
                                    placeholder="Nhập tên nhân viên">
                                @error('name')
                                    <div class="text-danger mt-2" id="name-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="service_category">Danh mục</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id "
                                    name="category_id">
                                    <option value="" disabled selected>Chọn danh mục</option>
                                    @foreach ($getServiceCategoy as $serviceCategory)
                                        <option value="{{ $serviceCategory->id }}"
                                            {{ $getServiceId->category_id == $serviceCategory->id ? 'selected' : '' }}>
                                            {{ $serviceCategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id ')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="form-label" for="email">Mô tả</label>
                                <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                                    name="description" placeholder="Nhập mô tả">{{ $getServiceId->description }}</textarea>
                                @error('description')
                                    <div class="text-danger mt-2" id="email-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Số điện thoại -->
                            <div class="mb-4">
                                <label class="form-label" for="phone">Thời gian</label>
                                <input type="text" class="form-control @error('duration') is-invalid @enderror"
                                    id="duration" name="duration" value="{{ $getServiceId->duration }}"
                                    placeholder="Nhập thời gian">
                                @error('duration')
                                    <div class="text-danger mt-2" id="phone-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ảnh đại diện -->
                            <div class="mb-4">
                                <label class="form-label" for="price">Giá</label>
                                <input type="text" class="form-control @error('price') is-invalid @enderror"
                                    value="{{ $getServiceId->price }}" id="price" name="price" placeholder="Nhập giá">
                                @error('price')
                                    <div class="text-danger mt-2" id="image-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mb-4">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
