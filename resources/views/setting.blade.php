@extends('layouts.backend')

@section('css')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="d-flex justify-content-between content-heading pt-0">
                        <h2 class="content-heading pt-0 border-0 mb-0">Cài đặt</h2>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-xl-8 offset-xl-2">
                            <div class="mb-3">
                                <label class="form-label" for="name">Tên hệ thống</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $settings->name) }}">
                                @error('name')
                                    <div class="text-danger mt-2" id="name-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ảnh đại diện -->
                            <div class="mb-3">
                                <label class="form-label" for="image">Logo</label>
                                <div id="my-dropzone" class="dropzone"></div>

                                <input type="hidden" name="logo" id="uploadedImage" value="">
                                @error('logo')
                                    <div class="text-danger mt-2" id="image-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="slogan">Thông điệp ngắn</label>
                                <input type="text" class="form-control @error('slogan') is-invalid @enderror"
                                    id="slogan" name="slogan" value="{{ old('slogan', $settings->slogan) }}">
                                @error('slogan')
                                    <div class="text-danger mt-2" id="slogan-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phone">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="contact_phone"
                                    value="{{ old('contact_phone', $settings->contact_phone) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" class="form-control @error('contact_email') is-invalid @enderror"
                                    id="email" name="contact_email"
                                    value="{{ old('contact_email', $settings->contact_email) }}">
                                @error('contact_email')
                                    <div class="text-danger mt-2" id="email-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="facebook">Link Facebook</label>
                                <input type="text" class="form-control @error('facebook') is-invalid @enderror"
                                    id="facebook" name="facebook" value="{{ old('facebook', $settings->facebook) }}">
                                @error('facebook')
                                    <div class="text-danger mt-2" id="facebook-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="messenger">Link Messenger</label>
                                <input type="text" class="form-control @error('messenger') is-invalid @enderror"
                                    id="messenger" name="messenger" value="{{ old('messenger', $settings->messenger) }}">
                                @error('messenger')
                                    <div class="text-danger mt-2" id="messenger-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="zalo">Link Zalo</label>
                                <input type="text" class="form-control @error('zalo') is-invalid @enderror"
                                    id="zalo" name="zalo" value="{{ old('zalo', $settings->zalo) }}">
                                @error('zalo')
                                    <div class="text-danger mt-2" id="zalo-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="instagram">Link Instagram</label>
                                <input type="text" class="form-control @error('instagram') is-invalid @enderror"
                                    id="instagram" name="instagram"
                                    value="{{ old('instagram', $settings->instagram) }}">
                                @error('instagram')
                                    <div class="text-danger mt-2" id="instagram-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="youtube">Link Youtube</label>
                                <input type="text" class="form-control @error('youtube') is-invalid @enderror"
                                    id="youtube" name="youtube" value="{{ old('youtube', $settings->youtube) }}">
                                @error('youtube')
                                    <div class="text-danger mt-2" id="youtube-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="tiktok">Link Tiktok</label>
                                <input type="text" class="form-control @error('tiktok') is-invalid @enderror"
                                    id="tiktok" name="tiktok" value="{{ old('tiktok', $settings->tiktok) }}">
                                @error('tiktok')
                                    <div class="text-danger mt-2" id="tiktok-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mb-3">Lưu</button>
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
            paramName: "file",
            dictDefaultMessage: "Kéo thả ảnh vào đây hoặc nhấp để chọn ảnh",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            init: function() {
                var existingImagePath = "{{ $settings->logo }}";

                var myDropzone = this;
                var uploadedImageInput = document.getElementById("uploadedImage");

                if (existingImagePath != "") {
                    var mockFile = {
                        name: "Ảnh hiện tại",
                        size: 100,
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
                }

                this.on("addedfile", function(file) {
                    if (myDropzone.files.length > 1) {
                        // Nếu đã có file, xóa file cũ
                        myDropzone.removeFile(myDropzone.files[0]);
                    }
                });

                this.on("success", function(file, response) {
                    uploadedImageInput.value = response.path;
                    file.kind = 'new';
                });

                this.on("error", function(file, errorMessage) {
                    console.log(errorMessage);
                });
            },
        };

        document.addEventListener('DOMContentLoaded', function() {
            const fields = ['name', 'email', 'facebook', 'instagram', 'messenger', 'tittok', 'youtube', 'linkedin',
                'zalo'
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
        });
    </script>
@endsection
