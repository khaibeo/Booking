@extends('layouts.backend');

@section('css')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Cập nhật nhân viên</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.users.index') }}" style="color: inherit;">Nhân viên</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Cập nhật nhân viên</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <h2 class="content-heading pt-0">Cập nhật nhân viên</h2>

                    <div class="row">
                        <div class="col-lg-12 col-xl-8 offset-xl-2">
                            <!-- Tên nhân viên -->
                            <div class="mb-4">
                                <label class="form-label" for="name">Tên nhân viên</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $user->name }}" placeholder="Nhập tên nhân viên">
                                @error('name')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $user->email }}" placeholder="Nhập email">
                                @error('email')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Số điện thoại -->
                            <div class="mb-4">
                                <label class="form-label" for="phone">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ $user->phone ?? old('phone', $user->phone) }}"
                                    placeholder="Nhập s điện thoại">
                                @error('phone')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ảnh đại diện -->
                            <div class="mb-4">
                                <label class="form-label" for="image">Ảnh đại diện</label>

                                <div id="my-dropzone" class="dropzone"></div>

                                <input type="hidden" name="image_id" id="uploadedImage" value="{{ $image['id'] }}">

                                @error('image_id')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Chọn cửa hàng -->
                            @if (auth()->user()->role == 'admin')
                                <div class="mb-4">
                                    <label class="form-label" for="store_id">Cửa hàng</label>
                                    <select class="form-control" id="store_id" name="store_id">
                                        <option value="" disabled selected>Chọn cửa hàng</option>
                                        @foreach ($stores as $store)
                                            <option value="{{ $store->id }}"
                                                {{ $store->id == $user->store_id ? 'selected' : '' }}>
                                                {{ $store->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('store_id')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <!-- Vai trò -->
                            <div class="mb-4">
                                <label class="form-label" for="role">Vai trò</label>
                                <select class="form-control" id="role" name="role">
                                    @if (auth()->user()->role == 'admin')
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Quản lý
                                        </option>
                                    @endif

                                    <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Nhân viên
                                    </option>
                                    <option value="cashier" {{ $user->role == 'cashier' ? 'selected' : '' }}>Thu ngân
                                    </option>
                                </select>
                                @error('role')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mô tả -->
                            <div class="mb-4">
                                <label class="form-label" for="biography">Tiểu sử</label>
                                <textarea class="form-control" id="biography" name="biography" rows="4" placeholder="Nhập mô tả">{{ $user->biography }}</textarea>
                                @error('biography')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Trạng thái hết hạn -->
                            <div class="mb-4">
                                <label class="form-label" for="is_locked">Trạng thái</label>
                                <select class="form-control" id="is_locked" name="is_locked">
                                    <option value="0" {{ $user->is_locked == '0' ? 'selected' : '' }}>Hoạt động
                                    </option>
                                    <option value="1" {{ $user->is_locked == '1' ? 'selected' : '' }}>Khóa</option>
                                </select>
                                @error('is_locked')
                                    <div class="text-danger mt-2">{{ $message }}</div>
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
                const existingImageId = "{{ $image['id'] }}";
                const existingImageName = "{{ $image['name'] }}";
                const existingImagePath = "{{ $image['path'] }}";
                const existingImageSize = "{{ $image['size'] }}";
                const myDropzone = this;
                const uploadedImageInput = document.getElementById("uploadedImage");

                if (existingImageId) {
                    var mockFile = {
                        name: `${existingImageName}`,
                        size: `${existingImageSize}`,
                        accepted: true,
                        kind: 'existing'
                    };
                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("accepted", mockFile);
                    myDropzone.emit("complete", mockFile);
                    myDropzone.files.push(mockFile);

                    var thumbnailElement = mockFile.previewElement.querySelector(".dz-image img");
                    thumbnailElement.src = '{{ asset('storage/') }}' + '/' + existingImagePath;
                    thumbnailElement.style.maxWidth = "100%";
                    thumbnailElement.style.height = "auto";
                    thumbnailElement.style.objectFit = "contain";

                    uploadedImageInput.value = existingImageId;
                }

                this.on("addedfile", function(file) {
                    if (myDropzone.files.length > 1) {
                        myDropzone.removeFile(myDropzone.files[0]);
                    }
                });

                this.on("success", function(file, response) {
                    uploadedImageInput.value = response.image_id;
                    file.kind = 'new';
                });

                this.on("removedfile", function(file) {
                    if (file.kind === 'existing' || myDropzone.files.length === 0) {
                        uploadedImageInput.value = '';
                    }
                });

                this.on("error", function(file, errorMessage) {
                    console.log(errorMessage);
                });
            },
        };
    </script>
@endsection
