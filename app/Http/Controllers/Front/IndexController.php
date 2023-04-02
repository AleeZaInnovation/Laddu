<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;

class IndexController extends Controller
{
    //
    public function index(){
        $sliderBanners = Banner::where('type','Slider')->where('status',1)->get()->toArray();
        //dd($sliderBanners);
        $fixBanners = Banner::where('type','Fix')->where('status',1)->get()->toArray();
        $newProducts = Product::orderBy('id','DESC')->where('status',1)->limit('8')->get()->toArray();
        $bestSeller = Product::where(['is_bestseller'=>'yes','status'=>1])->inRandomOrder()->limit('8')->get()->toArray();
        $discountedProducts = Product::where('product_discount','>',0)->where('status',1)->inRandomOrder()->limit('8')->get()->toArray();
        $feateredProducts = Product::where(['is_featured'=>'yes','status'=>1])->inRandomOrder()->limit('8')->get()->toArray();
        //dd($discountedProducts);
        return view('front.index')->with(compact('sliderBanners','fixBanners','newProducts','bestSeller','discountedProducts','feateredProducts'));
    }
}
