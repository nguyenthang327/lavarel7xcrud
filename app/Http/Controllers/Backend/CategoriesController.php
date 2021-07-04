<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\CategoriesModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    //
    public function index(Request $request){

        //$categories = CategoriesModel::all();

        $categories = DB::table('categories')->paginate(10);

        $data = [];
        $data["categories"] = $categories;
        return view("backend.categories.index",$data);
    }

    public function create(){
        return view("backend.categories.create");
    }

    public function edit($id){
        $category = CategoriesModel::findOrFail($id);

        $data = [];
        $data['category'] = $category;

        return view("backend.categories.edit",$data);
    }

    public function delete($id){
        $category = CategoriesModel::findOrFail($id);

        $data = [];
        $data['category'] = $category;
        return view("backend.categories.delete",$data);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'category_name' => 'required',
            'category_slug' => 'required',
            'category_image' => 'required',
            'category_desc' => 'required',
        ]);

        $category_name = $request->input('category_name',"");
        $category_slug = $request->input('category_slug',"");
        $category_desc = $request->input('category_desc',"");

        $pathCategoryImage = $request->file('category_image')->store('public/categoryImages');
        var_dump("$pathCategoryImage");
        
        $category = new CategoriesModel();
        
        $category->category_name = $category_name;
        $category->category_slug = $category_slug;
        $category->category_desc = $category_desc;
        $category->category_image = $pathCategoryImage;

        $category->save();
        return redirect('/backend/category/index')->with('status', " Cập nhật danh mục thành công");
    }
    
    public function update(Request $request,$id){
        $validatedData = $request->validate([
            'category_name' => 'required',
            'category_slug' => 'required',
            'category_desc' => 'required',
        ]);

        $category_name = $request->input('category_name',"");
        $category_slug = $request->input('category_slug',"");
        $category_desc = $request->input('category_desc',"");

        $category = CategoriesModel::findOrFail($id);

        $category->category_name = $category_name;
        $category->category_slug = $category_slug;
        $category->category_desc = $category_desc;
        //$category->category_image ="";

        if($request->hasFile('category_image')){

            if($category->category_image){
                Storage::delete($category->category_image);
            }
            $pathCategoryImage = $request->file('category_image')->store('public/categoryImages');
            $category->category_image = $pathCategoryImage;
        }

        $category->save();
        return redirect("/backend/category/edit/$id")->with('status',"Update is successful");

    }

    public function destroy ($id){
        $category = CategoriesModel::findOrFail($id);

        $category->delete();
        return redirect("/backend/category/index")->with('status', `Destroy id: {$id} is successfull`);
    }
}
