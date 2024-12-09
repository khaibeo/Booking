@extends('layouts.backend')

@section('content')
    <div class="content content-full content-boxed">
        <!-- Hero -->
        <div class="rounded border overflow-hidden push">
            <div class="px-4 py-3 bg-body-extra-light d-flex flex-column flex-md-row align-items-center">
                <a class="d-block img-link">
                    <img class="img-avatar img-avatar128 img-avatar-thumb" src="{{ Storage::url($user->image->path) }}" alt="">
                </a>
                <div class="ms-3 flex-grow-1 text-center text-md-start my-3 my-md-0">
                    <h1 class="fs-4 fw-bold mb-1">{{ $user->name }}</h1>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Edit Account -->
        <div class="block block-bordered block-rounded">
            <ul class="nav nav-tabs nav-tabs-alt" role="tablist">
                <li class="nav-item">
                    <button class="nav-link space-x-1 active" id="account-profile-tab" data-bs-toggle="tab"
                        data-bs-target="#account-profile" role="tab" aria-controls="account-profile"
                        aria-selected="true">
                        <i class="fa fa-user-circle d-sm-none"></i>
                        <span class="d-none d-sm-inline">Thông tin cá nhân</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link space-x-1" id="account-password-tab" data-bs-toggle="tab"
                        data-bs-target="#account-password" role="tab" aria-controls="account-password"
                        aria-selected="false">
                        <i class="fa fa-asterisk d-sm-none"></i>
                        <span class="d-none d-sm-inline">Đổi mật khẩu</span>
                    </button>
                </li>
            </ul>
            <div class="block-content tab-content">
                <div class="tab-pane active" id="account-profile" role="tabpanel" aria-labelledby="account-profile-tab"
                    tabindex="0">
                    <div class="row push p-sm-2 p-lg-4">
                        <div class="offset-xl-1 col-xl-4 order-xl-1">
                            <p class="bg-body-light p-4 rounded-3 text-muted fs-sm">
                                Họ và tên sẽ được hiển thị công khai
                            </p>
                        </div>
                        <div class="col-xl-6 order-xl-0">
                            <form action="{{ route('admin.profile.update', $user) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label class="form-label" for="dm-profile-edit-name">Họ và tên</label>
                                    <input type="text" class="form-control" name="name" id="dm-profile-edit-name"
                                        name="dm-profile-edit-name" value="{{ $user->name }}">
                                    @error('name')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="dm-profile-edit-email">Email</label>
                                    <input type="email" class="form-control" name="email" id="dm-profile-edit-email"
                                        name="dm-profile-edit-email" value="{{ $user->email }}">
                                    @error('email')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="dm-profile-edit-phone">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone" id="dm-profile-edit-phone"
                                        name="dm-profile-edit-phone" placeholder="Add your job title.."
                                        value="{{ $user->phone }}">
                                    @error('phone')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="biography">Tiểu sử</label>
                                    <textarea class="form-control" name="biography" id="biography" cols="30" rows="5">{{ $user->biography }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Ảnh đại diện mới</label>
                                    <input class="form-control" name="image" type="file" id="dm-profile-edit-avatar"
                                        accept="image/*">
                                    @error('image')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-alt-primary">
                                    <i class="fa fa-check-circle opacity-50 me-1"></i> Cập nhật
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="account-password" role="tabpanel" aria-labelledby="account-password-tab"
                    tabindex="0">
                    <div class="row push p-sm-2 p-lg-4">
                        <div class="col-xl-6 order-xl-0">
                            <form id="form-change-password" action="{{ route('admin.profile.change-password', $user) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label class="form-label" for="dm-profile-edit-password">Mật khẩu hiện tại</label>
                                    <input type="password" class="form-control" id="dm-profile-edit-password"
                                        name="old_password" value="{{ old('old_password') }}">
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label" for="dm-profile-edit-password-new">Mật khẩu mới</label>
                                        <input type="password" class="form-control" id="dm-profile-edit-password-new"
                                            name="new_password" value="{{ old('new_password') }}">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label" for="dm-profile-edit-password-new-confirm">Nhập lại mật
                                            khẩu</label>
                                        <input type="password" class="form-control"
                                            id="dm-profile-edit-password-new-confirm" name="confirm_password"
                                            value="{{ old('new_password') }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-alt-primary">
                                    <i class="fa fa-check-circle opacity-50 me-1"></i> Thay đổi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Edit Account -->
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('#form-change-password');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const errorElements = form.querySelectorAll('.text-danger');
                errorElements.forEach(el => el.remove());

                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Dashmix.helpers('jq-notify', {
                                type: 'success',
                                icon: 'fa fa-times me-1',
                                message: 'Thay đổi mật khẩu thành công'
                            });

                            form.reset();
                        } else if (data.errors) {
                            console.log(data.errors);

                            displayApiErrors(data.errors);
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    });
            });

            function displayApiErrors(errors) {
                Object.keys(errors).forEach(field => {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input) {
                        const errorMessage = errors[field][0];
                        const errorElement = document.createElement('div');
                        errorElement.classList.add('text-danger', 'mt-2');
                        errorElement.textContent = errorMessage;

                        input.parentNode.insertBefore(errorElement, input.nextSibling);
                    }
                });
            }
        });
    </script>
@endsection
