@extends('layouts.backend');

@section('css')
@endsection

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Cập nhật danh mục</h1>
            <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.service-category.index') }}" style="color: inherit;">Danh mục</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Cập nhật danh mục</li>
                </ol>
            </nav>
        </div>
    </div>
  </div>
  <!-- END Hero -->
  <div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('admin.service-category.update', $service_category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h2 class="content-heading pt-0">Cập nhật danh mục</h2>

                <div class="row">
                    <div class="col-lg-12 col-xl-8 offset-xl-2">
                        <!-- Tên nhân viên -->
                        <div class="mb-4">
                            <label class="form-label" for="name">Tên danh mục</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $service_category->name) }}" placeholder="Nhập tên danh mục" >
                            @error('name')
                                <div class="text-danger mt-2" id="name-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="name">Mô tả</label>
                            <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description"  placeholder="Mô tả" >{{ old('name', $service_category->description) }}</textarea>
                            @error('description')
                                <div class="text-danger mt-2" id="name-error">{{ $message }}</div>
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
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const fields = ['name', 'email', 'phone', 'image', 'password', 'store_id', 'role', 'biography', 'expired'];

    fields.forEach(function(field) {
        const inputElement = document.getElementById(field);
        const errorElement = document.getElementById(`${field}-error`);

        if (inputElement) {
            inputElement.addEventListener('input', function () {

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
