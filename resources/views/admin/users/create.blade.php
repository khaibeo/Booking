@extends('layouts.backend');

@section('css')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Thêm mới nhân viên</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.users.index') }}" style="color: inherit;">Nhân viên</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm mới nhân viên</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content">
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h2 class="content-heading pt-0">Thêm mới nhân viên</h2>

                    <div class="row">
                        <div class="col-lg-12 col-xl-8 offset-xl-2">
                            <!-- Tên nhân viên -->
                            <div class="mb-4">
                                <label class="form-label" for="name">Tên nhân viên</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Nhập tên nhân viên">
                                @error('name')
                                    <div class="text-danger mt-2" id="name-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="Nhập email">
                                @error('email')
                                    <div class="text-danger mt-2" id="email-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Số điện thoại -->
                            <div class="mb-4">
                                <label class="form-label" for="phone">Số điện thoại</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}"
                                    placeholder="Nhập số điện thoại">
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

                            <!-- Mật khẩu -->
                            <div class="mb-4">
                                <label class="form-label" for="password">Mật khẩu</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Nhập mật khẩu">
                                @error('password')
                                    <div class="text-danger mt-2" id="password-error">{{ $message }}</div>
                                @enderror
                            </div>

                            @if (auth()->user()->role == 'admin')
                                <!-- Chọn cửa hàng -->
                                <div class="mb-4">
                                    <label class="form-label" for="store_id">Cửa hàng</label>
                                    <select class="form-control @error('store_id') is-invalid @enderror" id="store_id"
                                        name="store_id">
                                        <option value="" disabled selected>Chọn cửa hàng</option>
                                        @foreach ($stores as $store)
                                            <option value="{{ $store->id }}"
                                                {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                                {{ $store->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('store_id')
                                        <div class="text-danger mt-2" id="store_id-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <!-- Vai trò -->
                            <div class="mb-4">
                                <label class="form-label" for="role">Vai trò</label>
                                <select class="form-control @error('role') is-invalid @enderror" id="role"
                                    name="role">
                                    @if (auth()->user()->role == 'admin')
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Quản lý
                                    </option>
                                    @endif
                                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Nhân viên
                                    </option>
                                    <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Thu ngân
                                    </option>
                                </select>
                                @error('role')
                                    <div class="text-danger mt-2" id="role-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mô tả -->
                            <div class="mb-4">
                                <label class="form-label" for="biography">Tiểu sử</label>
                                <textarea class="form-control @error('biography') is-invalid @enderror" id="biography" name="biography"
                                    rows="4" placeholder="Nhập mô tả">{{ old('biography') }}</textarea>
                                @error('biography')
                                    <div class="text-danger mt-2" id="biography-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Trạng thái hết hạn -->
                            <div class="mb-4">
                                <label class="form-label" for="is_locked">Trạng thái</label>
                                <select class="form-control @error('is_locked') is-invalid @enderror" id="is_locked"
                                    name="is_locked">
                                    <option value="0" {{ old('is_locked') == '0' ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="1" {{ old('is_locked') == '1' ? 'selected' : '' }}>Khóa</option>
                                </select>
                                @error('is_locked')
                                    <div class="text-danger mt-2" id="is_locked-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mb-4">Thêm nhân viên</button>
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

        const fields = ['name', 'email', 'phone', 'image', 'password', 'store_id', 'role', 'biography',
            'is_locked'
        ];

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
    </script>
@endsection
