@extends("backend.layouts.main")

@section('title', 'Danh sách sản phẩm')

@section('content')
    <h1>Danh sách sản phẩm</h1>

    <!-- Search -->
    <div style="padding: 10px; border: 1px solid #4e73df; margin-bottom:10px">
        <form name="search_product" method="get" action="{{ htmlspecialchars($_SERVER["REQUEST_URI"]) }}" class="form-inline">

            <input name="product_name" value="{{ $searchKeyword }}" class="form-control" placeholder="Nhập tên sản phẩm cần tìm" autocomplete="off" style="width:350px; margin-right:20px">

            <select name="product_status" class="form-control" style="width: 150px; margin-right: 20px">

                <option value="">Lọc theo trạng thái</option>
                <option value="1" {{ $productStatus == 1 ? "checked" : ""}}>Đang mở bán</option>
                <option value="2" {{ $productStatus == 2 ? "checked" : ""}}>Ngừng bán</option>

            </select>

            <select name="product_sort" class="form-control" style="width: 150px; margin-right: 20px">

                <option value="">Sắp xếp</option>
                <option value="price_asc" {{ $sort == "price_asc" ? "selected" : "" }}>Giá tăng dần</option>
                <option value="price_desc" {{ $sort == "price_desc" ? "selected" : "" }}>Giá giảm dần</option>
                <option value="quantity_asc" {{ $sort == "quantity_asc" ? "selected" : "" }}>Tồn kho tăng dần</option>
                <option value="quantity_desc" {{ $sort == "quantity_desc" ? "selected" : "" }}>Tồn kho giảm dần</option>

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

    {{ $products->links() }}
    
    <!-- end_Search -->
    
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status')}}
        </div>
    @endif

    <div style="padding:20px">
        <a href="{{ asset('/backend/product/create')}}" class="btn btn-info">Thêm sản phẩm</a>
    </div>

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Id sản phẩm</th>
                <th>Ảnh đại diện</th>
                <th>Tên sản phẩm</th>
                <th>Giá sản phẩm</th>
                <th>Tồn kho</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Id sản phẩm</th>
                <th>Ảnh đại diện</th>
                <th>Tên sản phẩm</th>
                <th>Giá sản phẩm</th>
                <th>Tồn kho</th>
                <th>Hành động</th>
            </tr>
        </tfoot>
        <tbody>
            @if (isset($products) && !empty($products))
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id}}</td>
                        <td>
                            @if($product->product_image)
                                <?php
                                    $product->product_image = str_replace("public/","",$product->product_image);
                                ?>
                                
                                <div>
                                    <img src="{{ asset("storage/$product->product_image") }}" style="width:200px; height:auto;">
                                </div>
                            @endif
                        </td>
                        <td>
                            {{ $product->product_name}}

                            @if($product->product_status==1)
                                <p><span class="bg-success text-white">Đang bán</span></p>
                            @endif

                            @if($product->product_status==2)
                                <p><span class="bg-danger text-white">Ngừng bán</span></p>
                            @endif
                        </td>
                        <td>{{ $product->product_price}}</td>
                        <td>{{ $product->product_quantity}}</td>
                        <td>
                            <a href="{{ url("/backend/product/edit/$product->id") }}" class="btn btn-warning">edit sản phẩm</a>
                            <a href="{{ url("/backend/product/delete/$product->id") }}" class="btn btn-danger">delete sản phẩm</a>
                        </td>
                    </tr>
                @endforeach
            @else
                Chưa có bản ghi nào trong bảng này
            @endif

        </tbody>
    </table>

    {{ $products->links() }}
@endsection

@section('appendjs')

    <!-- JQuery to clear-search -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#clear-search").on("click", function(e){
                e.preventDefault();

                // .val('') truyền vào ô input name = product_name 1 chuỗi rỗng
                $("input[name='product_name']").val('');
                $("select[name='product_status']").val('');
                $("select[name='product_sort']").val('');


                // method trigger dược kích hoạt tự động sự kiện submit của form
                $("form[name='search_product']").trigger("submit");
            });

            $("a.page-link").on("click", function(e){
                e.preventDefault();

                // Thêm attribute rel
                var rel=$(this).attr("rel");

                if(rel == "next"){
                    var page = $("body").find("page-item.active > page-link").eq(0).text();
                    console.log(page);
                    page = parseInt(page);
                    page = -1;
                }
                else{
                    var page = $(this).text();
                }

                console.log(page);

                $("input[name='page']").val(page);

                $("form[name=['search_product']").trigger("submit");

            });
        });

        

    </script>

@endsection