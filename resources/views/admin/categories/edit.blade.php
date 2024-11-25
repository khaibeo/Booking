@extends('layouts.backend');

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Cập nhật danh mục</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.categories.index') }}" style="color: inherit;">Danh mục</a>
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
                <form action="{{ route('admin.categories.update', $categoryService->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <h2 class="content-heading pt-0">Cập nhật danh mục</h2>

                    <div class="row">
                        <div class="col-lg-12 col-xl-8 offset-xl-2">
                            <!-- Tên nhân viên -->
                            <div class="mb-3">
                                <label class="form-label" for="name">Tên danh mục</label>
                                <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Nhập tên danh mục" value="{{$categoryService->name}}">
                                @error('name')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mô tả -->
                            <div class="mb-3">
                                <label class="form-label" for="description">Mô tả</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $categoryService->description }}</textarea>
                                @error('description')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end column-gap-3">
                                <a class="btn btn-warning text-white" href="{{ route('admin.categories.index') }}">Quay
                                    lại</a>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
