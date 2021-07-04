@extends("backend.layouts.main")

@section('title',"Tạo danh mục sản phẩm")

@section('content')
    <h1>Tạo mới danh mục</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="padding: 10px; border: 1px solid #4e73df; margin-bottom:10px">
        <form action="{{ url("/backend/category/store") }}" method="post" name="category" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="category_name">Tên danh mục:</label>
                <input type="text" class="form-control" placeholder="Nhập tên danh mục" name="category_name" id="category_name">
            </div>
            
            <div class="form-group">
                <label for="category_slug">Slug danh mục:</label>
                <input type="text" class="form-control" placeholder="Nhập slug danh mục" name="category_slug" id="category_slug">
            </div>

            <div class="form-group">
                <label for="category_image">Ảnh danh mục:</label>
                <input type="file" class="form-control" placeholder="Ảnh danh mục" name="category_image" id="category_image">
            </div>
            
            <div class="form-group">
                <label for="category_desc">Mô tả:</label>
                <textarea type="text" class="form-control" name="category_desc" id="category_desc" rows="10"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection

@section('appendjs')

    <script src="{{ asset("/be-assets/js/tinymce/tinymce.min.js") }}"></script>
    
    <script>
        tinymce.init({
            selector: '#category_desc'
        });
    </script>
@endsection