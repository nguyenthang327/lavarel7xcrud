@extends("backend.layouts.main")

@section('title', 'Xoá sản phẩm')

@section('content')
    <h1>Xoá sản phẩm</h1>

    <form action="{{ url("/backend/product/destroy/$product->id") }}" name="product" method="POST">
        @csrf
        <div class="form-group">
            <label for="product_id">ID sản phẩm:</label>
            <p>{{ $product->id}}</p>
        </div>

        <div class="form-group">
            <label for="product_name">Tên sản phẩm:</label>
            <p>{{ $product->product_name}}</p>
        </div>

        <button type="submit" class="btn btn-danger">Xoá sản phẩm</button>
    </form>

@endsection