@extends('layouts.booking')

@section('booking')

    <main id="page-container">
        <div class="content">
            <div class="row">
                <h3>Danh sách cửa hàng</h3>
                <div class="col-xl-4">
                    <!-- Search -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Tìm kiếm cửa hàng</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <form action="" method="GET">
                                <div class="input-group">
                                    <input type="text" value="{{ request('keyword') }}" name="keyword" class="form-control form-control-alt"
                                           placeholder="Nhập tên cửa hàng hoặc địa chỉ..">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END Search -->
                </div>
                <div class="col-xl-8">
                    @foreach ($stores as $store)
                        <!-- Story -->
                    <div class="block block-rounded side-scroll">
                        <div class="block-content p-0 overflow-hidden">
                            <div class="row g-0">
                                <div class="col-md-4 col-lg-5 overflow-hidden d-flex align-items-center">
                                    @if($store->is_active)
                                        <a href="{{route('booking-detail', $store)}}">
                                            <img class="img-fluid img-link" src="{{ Storage::url($store->image?->path) }}" alt="">
                                        </a>
                                    @else
                                        <img class="img-fluid img-link opacity-60" src="{{ Storage::url($store->image?->path) }}" alt="">
                                    @endif
                                </div>
                                <div class="col-md-8 col-lg-7 d-flex align-items-center">
                                    <div class="px-4 py-3">
                                        <h4 class="mb-1">
                                            @if($store->is_active)
                                                <a class="text-dark" href="{{route('booking-detail', $store)}}">{{ $store->name }}</a>
                                            @else
                                                <span class="text-dark opacity-60">{{ $store->name }}</span>
                                                <p class="text-danger fs-6">Cửa hàng hiện không hoạt động trong 3 ngày tới !</p>
                                            @endif
                                        </h4>
                                        <div class="fs-sm mb-2">
                                            <a href="{{ $store->link_map }}">{{ $store->address }}</a>
                                        </div>
                                        <p class="mb-0">
                                            {{ Str::limit($store->description, 200) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Story -->
                    @endforeach

                    <div>
                        {{ $stores->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
@section('js')

@endsection
