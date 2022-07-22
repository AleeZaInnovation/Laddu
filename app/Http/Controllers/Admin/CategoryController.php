<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use Session;
use Image;

class CategoryController extends Controller
{
    //
    public function categories()
    {
        //
        Session::put('page','categories');
        $categories = Category::with(['section','parentcategory'])->get()->toArray();
        //dd($categories);
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }

            Category::where('id',$data['item_id'])->update(['status'=>$status]);

            return response()->json(['status'=>$status,'item_id'=>$data['item_id']]);
        }
    }

    public function addEditCategory(Request $request,$id=null){
        Session::put('page','categories');
        if($id==""){
            $title = "Add Category";
            $category = new Category;
            $getCategories = array();
            $message = "Category has been added.";
        }else{
            $title = "Edit category";
            $category = Category::find($id);
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,
            'section_id'=>$category['section_id']])->get();
            $message = "Category has been updated.";
        }

        $section = Section::get()->toArray();

        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data);
            if($data['category_discount']==""){
                $data['category_discount'] = 0; 
            }
            //echo "<pre>"; print_r($data); die;

            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
            ];

            $customesMessages = [
                'category_name.required' => 'Category name is required !',
                'category_name.regex' => 'Valid category name is required !',
                'section_id.required' => 'Section is required !',
                'url.required' => 'Category url is required !',
            ];

            $this->validate($request,$rules,$customesMessages);
            // Category Image
            if($request->hasFile('image')){
                $image = $request->file('image');
                if($image->isValid()){
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/category_image/'.$imageName;
                    Image::make($image)->save($imagePath);
                    $category->category_image = $imageName;
                }
            }else {
                $category->category_image = "";
            }
                $category->parent_id = $data['parent_id'];
                $category->category_name = $data['category_name'];
                $category->section_id = $data['section_id'];
                $category->category_discount = $data['category_discount'];
                $category->description = $data['description'];
                $category->meta_title = $data['meta_title'];
                $category->meta_description = $data['meta_description'];
                $category->meta_keywords = $data['meta_keywords'];
                $category->url = $data['url'];
                $category->status = 1;
                $category->save();


            return redirect('admin/categories')->with('success_message',$message);
        }
        return view('admin.categories.add_edit_category')->with(compact('title','category','section','getCategories'));
    }

    public function appendCategoryLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,
            'section_id'=>$data['section_id']])->get()->toArray();

            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }

    public function deleteCategory($id){
        Category::where('id',$id)->delete();
        $message = "Category has been deleted successfully .";
        return redirect()->back()->with('success_message',$message);
    }

    public function deleteCategoryImage($id){
        //echo "<pre>"; print_r("hello"); die;        
        $categoryImage = Category::select('category_image')->where('id',$id)->first();
        //dd($categoryImage);

        $category_image_path = 'front/images/category_image/';
        
        if(file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }	

        Category::where('id',$id)->update(['category_image'=>'']);

        $message = "Category image has been deleted successfully .";
        return redirect()->back()->with('success_message',$message);

    }
}
