<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsFilter;
use App\Models\ProductAttribute;

class ProductController extends Controller
{
    //
    public function listing( Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $url = $data['url']; 
            $_GET['sort'] = $data['sort'];

            $CountCatageory = Category::where(['url'=>$url,'status'=>1])->count();

            if($CountCatageory > 0){
                $categoryDetails = Category::categoryDetails($url);
                $productDetails = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);

                $productFilters = ProductsFilter::productFilters();

                foreach ($productFilters as $filter){
                    if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])){
                        $productDetails->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                    }
                }

       
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $productDetails->orderBy('products.id','Desc');
                    }elseif($_GET['sort']=="price_lowest"){
                        $productDetails->orderBy('products.product_price','Asc');
                    }elseif($_GET['sort']=="price_highest"){
                        $productDetails->orderBy('products.product_price','Desc');
                    }elseif($_GET['sort']=="name_a_z"){
                        $productDetails->orderBy('products.product_name','Asc');
                    }elseif($_GET['sort']=="name_z_a"){
                        $productDetails->orderBy('products.product_name','Desc');
                    }
                }

                if(isset($data['size']) && !empty($data['size'])){
                    $productIds = ProductAttribute::select('product_id')->whereIn('size',$data['size'])->pluck('product_id')->toArray();
                    $productDetails->whereIn('products.id',$productIds);
                }

                if(isset($data['color']) && !empty($data['color'])){
                    $productIds = Product::select('id')->whereIn('product_color',$data['color'])->pluck('id')->toArray();
                    $productDetails->whereIn('products.id',$productIds);
                }

                if(isset($data['price']) && !empty($data['price'])){
                    foreach($data['price'] as $key=>$price){
                        $explodePrices = explode('-',$price);
                        $productIds[] = Product::select('id')->whereBetween('product_price',[$explodePrices[0],$explodePrices[1]])->pluck('id')->toArray();
                    }
                        $productIds = call_user_func_array('array_merge',$productIds);
                        $productDetails->whereIn('products.id',$productIds);
                }

                if(isset($data['brand']) && !empty($data['brand'])){
                    $productIds = Product::select('id')->whereIn('brand_id',$data['brand'])->pluck('id')->toArray();
                    $productDetails->whereIn('products.id',$productIds);
                }
                //dd($categoryDetails);
                // echo('Category Exist'); die;
                $productDetails = $productDetails->paginate(30);
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','productDetails','url'));
            }else{
                abort(404);
            }
        }
        else{
            $url = Route::getFacadeRoot()->current()->uri(); 
            $CountCatageory = Category::where(['url'=>$url,'status'=>1])->count();

            if($CountCatageory > 0){
                $categoryDetails = Category::categoryDetails($url);
                $productDetails = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $productDetails->orderBy('products.id','Desc');
                    }elseif($_GET['sort']=="price_lowest"){
                        $productDetails->orderBy('products.product_price','Asc');
                    }elseif($_GET['sort']=="price_highest"){
                        $productDetails->orderBy('products.product_price','Desc');
                    }elseif($_GET['sort']=="name_a_z"){
                        $productDetails->orderBy('products.product_name','Asc');
                    }elseif($_GET['sort']=="name_z_a"){
                        $productDetails->orderBy('products.product_name','Desc');
                    }
                }
                //dd($categoryDetails);
                // echo('Category Exist'); die;
                $productDetails = $productDetails->paginate(30);
                return view('front.products.listing')->with(compact('categoryDetails','productDetails','url'));
            }else{
                abort(404);
            }
        }

    }
}
