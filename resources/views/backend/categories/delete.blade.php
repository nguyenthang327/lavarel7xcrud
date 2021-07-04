@extends("backend.layouts.main")

@section('title', 'Xoá danh mục')

@section('content')
    <h1>Xoá danh mục</h1>

    <form action="{{ url("/backend/category/destroy/$category->id") }}" name="category" method="POST">
        @csrf
        <div class="form-group">
            <label for="product_id">ID danh mục:</label>
            <p>{{ $category->id}}</p>
        </div>

        <div class="form-group">
            <label for="category_name">Tên danh mục:</label>
            <p>{{ $category->category_name}}</p>
        </div>

        <button type="submit" class="btn btn-danger">Xoá danh mục</button>
    </form>

@endsection