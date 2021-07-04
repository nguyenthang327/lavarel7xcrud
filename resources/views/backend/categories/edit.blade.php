@extends("backend.layouts.main")

@section('title',"Sửa danh mục sản phẩm")

@section('content')
    <h1>Sửa danh mục</h1>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status')}}
        </div>
    @endif

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
        <form action="{{ url("/backend/category/update/$category->id") }}" method="post" name="category" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="category_name">Tên danh mục:</label>
                <input type="text" class="form-control" placeholder="Nhập tên danh mục" name="category_name" id="category_name" value="{{ $category->category_name}}">
            </div>
            
            <div class="form-group">
                <label for="category_slug">Slug danh mục:</label>
                <input type="text" class="form-control" placeholder="Nhập slug danh mục" name="category_slug" id="category_slug" value="{{ $category->category_slug}}">
            </div>

            <div class="form-group">
                <label for="category_image">Ảnh danh mục:</label>
                <input type="file" class="form-control" placeholder="Ảnh danh mục" name="category_image" id="category_image">

                @if($category->category_image)
                    <?php
                        $category->category_image = str_replace("public/","",$category->category_image);
                    ?>

                    <div>
                        <img src="{{ asset("storage/$category->category_image") }}" style="width:200px; height:auto;">
                    </div>
                    
                @endif

            </div>
            
            <div class="form-group">
                <label for="category_desc">Mô tả:</label>
                <textarea type="text" class="form-control" name="category_desc" id="category_desc" rows="10">{{ $category->category_desc}}</textarea>
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