@extends("backend.layouts.main")

@section('title', 'Sửa sản phẩm')

@section('content')
    <h1>Sửa sản phẩm</h1>

    @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url("/backend/product/update/$product->id") }}" name="product" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="product_name">Tên sản phẩm:</label>
            <input type="text" name="product_name" class="form-control" id="product_name" value="{{ $product->product_name}}">
        </div>

        <div class="form-group">
            <label for="product_status">Trạng thái sản phẩm:</label>

            @php
                if($product->product_status == 1 ){
                    $checkedRadioStatus = "checked";
                }
                else{
                    $checkedRadioStatus = "";
                }
            @endphp

            <input type="radio" name="product_status" id="product_status" value="1" {{ $checkedRadioStatus}}> Đang mở bán

            @php
                if($product->product_status == 2 ){
                    $checkedRadioStatus = "checked";
                }
                else{
                    $checkedRadioStatus = "";
                }
            @endphp

            <input type="radio" name="product_status" id="product_status" value="2" {{ $checkedRadioStatus}}> Tạm thời dừng bán
        </div>

        <div class="form-group">
            <label for="product_image">Ảnh sản phẩm:</label>
            <input type="file" name="product_image" class="form-control" id="product_image" value="{{ $product->product_image}}">

            @if($product->product_image)

                <?php
                    $product->product_image = str_replace("public/","",$product->product_image)
                ?>
                
                <div>
                    <img src="{{ asset("storage/$product->product_image") }}" style="width:200px; height:auto;">
                </div>
            @endif

        </div>

        <div class="form-group">
            <label for="product_desc">Mô tả sản phẩm:</label>
            <textarea name="product_desc" class="form-control" rows="10" id="product_desc">{{ $product->product_desc}}</textarea>
        </div>

        <div>
            <label for="product_desc">Preview mô tả sản phẩm:</label>
            <div>
                {!! $product->product_desc !!}
            </div>
        </div>

        <div class="form-group">
            <label for="product_publish">Thời gian mở bán sản phẩm:</label>
            <input type="text" name="product_publish" class="form-control" id="product_publish" style="width: 250px" value="{{ $product->product_publish}}">
        </div>

        <div class="form-group">
            <label for="product_quantity">Tồn kho sản phẩm:</label>
            <input type="number" name="product_quantity" class="form-control" id="product_quantity" style="width: 250px" value="{{ $product->product_quantity}}">
        </div>

        <div class="form-group">
            <label for="product_price">Giá sản phẩm:</label>
            <input type="text" name="product_price" class="form-control" id="product_price" style="width: 250px" value="{{ $product->product_price}}">
        </div>

        <button type="submit" class="btn btn-info">Cập nhật sản phẩm</button>
    </form>

@endsection

@section("appendjs")
    <link rel="stylesheet" href=" asset("be-assets/js/bootstrap-datetimepicker.min.css") }} "/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/momment.js/2.21.0/moment.min.js" type="text/javascript"></script>

    <script rel="stylesheet" src="{{ asset("be-assets/js/bootstrap-datetimepicker.min.js") }}"></script>

    <script text="type/javascript">
        $(function() {
            $('#product_publish').datetimepicker({
                format:"YYYY-MM-DD HH:mm:ss",
                icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chervon-right',
                    today: 'fas fa-calendar-check',
                    clear: 'far fa-trash-alt',
                    close: 'far fa-times-circle'
                }
            });
        });
    </script>

    <script src="{{ asset("/be-assets/js/tinymce/tinymce.min.js") }}"></script>
    
    <script>
        tinymce.init({
            selector: '#product_desc'
        });
    </script>
@endsection