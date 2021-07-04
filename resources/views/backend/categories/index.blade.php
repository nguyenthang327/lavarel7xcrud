@extends("backend.layouts.main")

@section('title','Danh mục sản phẩm')

@section('content')
<h1>Danh mục sản phẩm</h1>

<!-- Search -->
<div style="padding: 10px; border: 1px solid #4e73df; margin-bottom:10px">
    <form name="search_category" method="get" action="{{ htmlspecialchars($_SERVER["REQUEST_URI"]) }}" class="form-inline">

        <input name="category_name" value="" class="form-control" placeholder="Nhập tên danh mục cần tìm" autocomplete="off" style="width:350px; margin-right:20px">

        <select name="category_sort" class="form-control" style="width: 150px; margin-right: 20px">

            <option value="">Sắp xếp</option>

        </select>

        <div style="padding:10px 0">
            <input type="submit" name="search" class="btn btn-success" value="Lọc kết quả">
        </div>

        <div style="padding:10px 0">
            <a href="#" id="clear-search" class="btn btn-warning">Clear filter</a>
        </div>

        <input type="hidden" name="page" value="1">

    </form>
</div>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status')}}
        </div>
    @endif

    <div style="padding:20px">
        <a href="{{ asset('/backend/category/create')}}" class="btn btn-info">Thêm danh mục sản phẩm</a>
    </div>


    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Id danh mục</th>
                <th>Ảnh đại diện</th>
                <th>Tên danh mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Id danh mục</th>
                <th>Ảnh đại diện</th>
                <th>Tên danh mục</th>
                <th>Hành động</th>
            </tr>
        </tfoot>
        <tbody>
            @if (isset($categories) && !empty($categories))
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id}}</td>
                        <td>
                            @if($category->category_image)
                                <?php
                                   $category->category_image = str_replace("public/","",$category->category_image);
                                ?>
                                
                                <div>
                                    <img src="{{ asset("storage/$category->category_image") }}" style="width:200px; height:auto;">
                                </div>
                            @endif 
                        </td>
                        <td>
                            {{ $category->category_name}}
                        </td>
            
                        <td>
                            <a href="{{ url("/backend/category/edit/$category->id") }}" class="btn btn-warning">edit danh mục</a>
                            <a href="{{ url("/backend/category/delete/$category->id") }}" class="btn btn-danger">delete danh mục</a>
                        </td>
                    </tr>
                @endforeach
            @else
                Chưa có bản ghi nào trong bảng này
            @endif

        </tbody>
    </table>
    {{ $categories->links() }}

@endsection