<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\ProductsModel;
use Illuminate\Http\Request;
// namspace to paginate
use Illuminate\Support\Facades\DB;
// namespace to action with storage
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    //
    public function index(Request $request){
        // Lấy ra tất cả bản ghi trong bảng products
        // $products = ProductsModel::all();
        
        //$products = DB::table('products')->paginate(10);
        // truyền dữ liệu xuống view

        $searchKeyword = $request->query('product_name',"");
        $productStatus = (int)$request->query('product_status',"");
        $allProductStatus = [1,2];
        $sort = $request->query('product_sort', "");

        $queryORM = ProductsModel::where('product_name', "LIKE","%".$searchKeyword."%");

        // kiểm tra xem trạng thái $productStatus được gửi đi có trong mảng $allProductStatus hay không
        if(in_array($productStatus,$allProductStatus)){
            // nếu toán tử là = thì ta không cần phải thêm vì mysql mặc định = rồi
            $queryORM = $queryORM->where('product_status',$productStatus);
        }

        if($sort == "price_asc"){
            $queryORM->orderBy('product_price', 'asc');
        }

        if($sort == "price_desc"){
            $queryORM->orderBy('product_price', 'desc');
        }

        if($sort == "quantity_asc"){
            $queryORM->orderBy('quantity_asc', 'asc');
        }

        if($sort == "quantity_desc"){
            $queryORM->orderBy('quantity_desc', 'desc');
        }

        $products = $queryORM->paginate(10);

        $data = [];
        $data["products"] = $products;

        // truyền keyword search xuống view;
        $data["searchKeyword"] = $searchKeyword;
        $data["productStatus"] = $productStatus;
        $data["sort"] = $sort;

        return view("backend.products.index",$data);
    }

    public function create(){
        return view("backend.products.create");
    }

    public function edit($id){
        $product = ProductsModel::findOrFail($id);
        
        // echo "<pre>";
        // print_r($product);
        // echo "</pre>";

        $data = [];
        $data["product"] = $product;

        return view("backend.products.edit",$data);
    }

    public function delete($id){
        $product = ProductsModel::findOrFail($id);

        $data = [];
        $data["product"] = $product;
        return view("backend.products.delete",$data);
    }

    public function store(Request $request){
        
        // validate dữ liệu
        $validatedData = $request->validate([
            'product_status' => 'required',
            'product_name' => 'required',
            'product_image' => 'required',
            'product_publish' => 'required',
            'product_desc' => 'required',
            'product_quantity' => 'required',
            'product_price' => 'required',
        ]);

        // lay du lieu submit
        $product_name = $request->input('product_name','');
        $product_status = $request->input('product_status',1);
        $product_desc = $request->input('product_desc','');
        $product_publish = $request->input('product_publish','');
        $product_quantity = $request->input('product_quantity',0);
        $product_price = $request->input('product_price',0);
       
        $pathProductImage = $request->file('product_image')->store('public/productimages');
        var_dump($pathProductImage);

        // khoi tao model cua product
        $product = new ProductsModel();


        // khi product_publish không được nhập dữ liệu
        // ta sẽ gán giá trị là thời gian hiện tại theo định dạng Y-m-d H:i:s
        if(!$product_publish){
            $product_publish = date("Y-m-d H:i:s");
        }

        // gán dữ liệu từ request cho các thuộc tính của biến $product
        // $product là đối tượng khởi tạo từ model ProductsModel
        $product->product_name = $product_name;
        $product->product_status = $product_status;
        $product->product_desc = $product_desc;
        $product->product_publish = $product_publish;
        $product->product_quantity = $product_quantity;
        $product->product_price = $product_price;
        $product->product_image = $pathProductImage;

        // gắn tạm product_image là rỗng "" vì ta chưa upload ảnh
        //$product->product_image = "";

        // Lưu sản phẩm
        $product->save();

        // chuyển hướng về trang /backend/product/index
        return redirect("/backend/product/index")->with('status', 'Thêm sản phẩm thành công !');
    }

    public function update(Request $request,$id){
        echo "id la:".$id;

        echo "<pre>";
        print_r($request->all());
        echo "</pre>";

        $validatedData = $request->validate([
            'product_name' => 'required',
            'product_publish' => 'required',
            'product_desc' => 'required',
            'product_quantity' => 'required',
            'product_price' => 'required',
        ]);

        $product_name = $request->input('product_name', '');
        $product_status = $request->input('product_status',1);
        $product_desc = $request->input('product_desc', '');
        $product_publish = $request->input('product_publish', '');  
        $product_quantity = $request->input('product_quantity', 0);   
        $product_price = $request->input('product_price', 0);
   
        // khi $product_publish không được nhập dữ liệu
        // ta sẽ gán giá trị là thời gian hiện tại theo định dạng Y-m-d H:i:s
        if (!$product_publish) {    
            $product_publish = date("Y-m-d H:i:s");
        }

        $product = ProductsModel::findOrFail($id);

        // gán dữ liệu từ request cho các thuộc tính của biến $product
        //$product là đối tượng khởi tạo từ model ProductsModel
        $product->product_name = $product_name;
        $product->product_status = $product_status;
        $product->product_desc = $product_desc;
        $product->product_publish = $product_publish;
        $product->product_quantity = $product_quantity;
        $product->product_price = $product_price;
        $product->product_image = "";

        if($request->hasFile('product_image')){

            if($product->product_image){
                Storage::delete($product->product_image);
            }

            $pathProductImage = $request->file('product_image')->store('public/productimages');
            $product->product_image = $pathProductImage;
        }

        $product->save();

        return redirect("/backend/product/edit/$id")->with('status', 'cập nhật trạng thái thành công');
    }

    public function destroy($id){
        $product = ProductsModel::findOrFail($id);
        $product->delete();
        return redirect("/backend/product/index")->with('status', "Đã xoá thành công sản phẩm có id: $id");
    }
}
