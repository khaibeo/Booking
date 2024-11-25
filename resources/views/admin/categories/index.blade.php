@extends('layouts.backend')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css"> 

@endsection

@section('content')
 <!-- Hero -->
 <div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Danh sách danh mục</h1>
            <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.categories.index') }}" style="color: inherit;">categories</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Danh sách danh mục</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
  <!-- END Hero -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Danh sách danh mục</h3>
            <div class="block-options">
                <div class="block-options-item">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Add"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="block-content">
            <table class="table table-hover" id="categoriesTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Tên danh mục</th>
                        <th class="d-none d-sm-table-cell">Mô tả</th>
                        <th class="d-none d-sm-table-cell">Ngày tạo</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold"><a href="{{route('admin.categories.edit',$item->id)}}">{{ $item->name }}</a></td>
                            <td class="d-none d-sm-table-cell">{{ \Str::limit($item->description, 30, '...') }}</td>
                            <td class="d-none d-sm-table-cell">{{ $item->created_at->format('d-m-Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    {{-- EDIT --}}
                                    <a href="{{route('admin.categories.edit',$item)}}" type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>

                                    {{-- DELETE  --}}
                                    <form action="{{route('admin.categories.destroy',$item)}}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này')">
                                        <i class="fa fa-times"></i>
                                      </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#categoriesTable').DataTable({
            "paging"      : true,          // Bật phân trang
            "pageLength"  : 10,        // Số bản ghi mỗi trang
            "lengthChange": true,    // thay đổi số bản ghi mỗi trang
            "searching"   : true,       // Bật tìm kiếm
            "info"        : true,            // Hiển thị thông tin phân trang
            "language"    : {
            "paginate"    : {
                "previous": "<i class='fa fa-angle-left'></i>",
                "next"    : "<i class='fa fa-angle-right'></i>"
                },
                "info"    : "Page _START_ of _PAGES_ ",
                "search"  : "Tìm kiếm:"
            }
        });
    });
</script>
@endsection