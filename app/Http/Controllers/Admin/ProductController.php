<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Section;
use App\Models\Brand;
use App\Models\Admin;
use App\Models\CAtegory;
use Session;
use Auth;
use Image;

class ProductController extends Controller
{
    //

    public function products()
    {
        //
        Session::put('page','products');
        $products = Product::with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');}
            ])->get()->toArray();
        //dd($products);
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }

            Product::where('id',$data['item_id'])->update(['status'=>$status]);

            return response()->json(['status'=>$status,'item_id'=>$data['item_id']]);
        }
    }

    public function deleteProduct($id){
        Product::where('id',$id)->delete();
        $message = "Product has been deleted successfully .";
        return redirect()->back()->with('success_message',$message);
    }

    public function addEditProduct(Request $request,$id=null){
        Session::put('page','products');
        if($id==""){
            $title = "Add Category";
            $product = new Product;
            //$getproducts = array();
            $message = "Product has been added.";
        }else{
            $title = "Edit Product";
            $product = Product::find($id);
            //$getproducts = Product::with('subproducts')->where(['parent_id'=>0,
            //'section_id'=>$product['section_id']])->get();
            $message = "Product has been updated.";
        }

        $categories = Section::with('categories')->get()->toArray();
        //dd($categories);
        $brands = Brand::get()->toArray();        

        if($request->isMethod('post')){
             $data = $request->all();
             //dd($data);
            //echo "<pre>"; print_r($data); die;
        //     if($data['product_discount']==""){
        //         $data['product_discount'] = 0; 
        //     }
             //echo "<pre>"; print_r(Auth::guard('admin')->user()); die;

            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^\w+$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
                
            ];

            $customesMessages = [
                'category_id.required' => 'Category id is required !',
                'product_name.required' => 'Product name is required !',
                'product_name.regex' => 'Valid product name is required !',
                'product_code.required' => 'Product code is required !',
                'product_code.regex' => 'Valid product code is required !',
                'product_price.required' => 'Product price is required !',
                'product_price.numeric' => 'Valid product price is required !',
                'product_color.required' => 'Product color is required !',
                'product_color.regex' => 'Valid product color is required !',
            ];

             $this->validate($request,$rules,$customesMessages);
            // Upload product image after resize large 1000x1000 , medium 500x500 , small 250 x 250 
            if($request->hasFile('image')){
                $image = $request->file('image');
                
                if($image->isValid()){
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extension;
                    $imageSmallPath = 'front/images/product_image/small/'.$imageName;
                    $imageMediumPath = 'front/images/product_image/medium/'.$imageName;
                    $imageLargePath = 'front/images/product_image/large/'.$imageName;
                    Image::make($image)->resize(250,250)->save($imageSmallPath);
                    Image::make($image)->resize(500,500)->save($imageMediumPath);
                    Image::make($image)->resize(1000,1000)->save($imageLargePath);
                    $product->product_image = $imageName;
                }
            }
            
            // Upload Product Video
            if($request->hasFile('product_video')){
                $video= $request->file('product_video');
                
                if($video->isValid()){
                    $extension = $video->getClientOriginalExtension();
                    $videoName = rand(111,99999).'.'.$extension;
                    $videoPath = 'front/videos/product_video/';
                    $video->move($videoPath,$videoName);
                    $product->product_video = $videoName;
                }
            }
                $categoryDetails = Category::find($data['category_id']);                
                $product->section_id = $categoryDetails['section_id'];
                $product->category_id = $data['category_id'];
                $product->brand_id = $data['brand_id'];

                $adminType = Auth::guard('admin')->user()->type;
                $vendor_id = Auth::guard('admin')->user()->vendor_id;
                $admin_id = Auth::guard('admin')->user()->id;

                $product->admin_type = $adminType;
                $product->admin_id = $admin_id;
                if($adminType=="vendor"){
                    $product->vendor_id = $vendor_id;
                }else {
                    $product->vendor_id = 0;
                }
                $product->admin_type = $adminType;
                $product->product_name = $data['product_name'];
                $product->product_code = $data['product_code'];
                $product->product_color = $data['product_color'];
                $product->product_price = $data['product_price'];
                $product->product_weight = $data['product_weight'];
                $product->product_discount = $data['product_discount'];
                $product->description = $data['description'];
                $product->meta_title = $data['meta_title'];
                $product->meta_description = $data['meta_description'];
                $product->meta_keywords = $data['meta_keywords'];
                if(!empty($data['is_featured'])){
                    $product->is_featured = $data['is_featured'];
                }else{
                    $product->is_featured = "No";
                }
                $product->status = 1;
                $product->save();


            return redirect('admin/products')->with('success_message',$message);
        }

        return view('admin.products.add_edit_product')->with(compact('title','categories','brands','product'));
    }

    public function deleteProductImage($id){
        //echo "<pre>"; print_r("hello"); die;        
        $productImage = Product::select('product_image')->where('id',$id)->first();
        //dd($ProductImage);

        $small_product_image_path = 'front/images/product_image/small/';
        $medium_product_image_path = 'front/images/product_image/medium/';
        $large_product_image_path = 'front/images/product_image/large/';
        
        if(file_exists($small_product_image_path.$productImage->product_image)){
            unlink($small_product_image_path.$productImage->product_image);
        }
        
        if(file_exists($medium_product_image_path.$productImage->product_image)){
            unlink($medium_product_image_path.$productImage->product_image);
        }

        if(file_exists($large_product_image_path.$productImage->product_image)){
            unlink($large_product_image_path.$productImage->product_image);
        }

        Product::where('id',$id)->update(['product_image'=>'']);

        $message = "Product image has been deleted successfully .";
        return redirect()->back()->with('success_message',$message);

    }

    public function deleteProductVideo($id){
        //echo "<pre>"; print_r("hello"); die;        
        $productVideo = Product::select('product_video')->where('id',$id)->first();
        //dd($Productvideo);

        $product_video_path = 'front/videos/product_video/';

        
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }
        

        Product::where('id',$id)->update(['product_video'=>'']);

        $message = "Product video has been deleted successfully .";
        return redirect()->back()->with('success_message',$message);

    }

    public function addProductAttribute(Request $request, $id){
        //echo "<pre>"; print_r("hello"); die;        
        $product = Product::find($id);
        //dd($product);

        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data);
           echo "<pre>"; print_r($data); die;

        }

        return view('admin.attributes.add_edit_attributes')->with(compact('product'));

  

    }
}


