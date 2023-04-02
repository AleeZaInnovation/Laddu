<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsFilter extends Model
{
    use HasFactory;

    public static function getFilterName($filter_id){
        $getFilterName = ProductsFilter::select('filter_name')->where('id',$filter_id)->first();
        return $getFilterName->filter_name;
    }

    public function filter_values(){
        return $this->hasMany('App\Models\ProductsFiltersValue','filter_id');
    }

    public static function productFilters(){
        $productFilters = ProductsFilter::with('filter_values')->where('status',1)->get()->toArray();
        return $productFilters;
    }

    public static function filterAvailable($filter_id,$category_id){
        $filterAvailable = ProductsFilter::select('cat_Ids')->where(['id'=>$filter_id,'status'=>1])->first()->toArray();

        $catIdsArr = explode(",",$filterAvailable['cat_Ids']);
        if(in_array($category_id,$catIdsArr)){
            $available = "Yes";
        }else {
            $available = "No";
        }
        return $available;
    }

    public static function getSizes($url){
        $catgoryDetails = Category::categoryDetails($url);
        
        $getProductsIds = Product::whereIn('category_id',$catgoryDetails['catIds'])->pluck('id')->toArray();
        $getProductSizes = ProductAttribute::select('size')->whereIn('product_id',$getProductsIds)->groupBy('size')->pluck('size')->toArray();

        // echo "<pre>"; print_r($getProductSizes); die;
        return $getProductSizes;
    }

    public static function getColors($url){
        $catgoryDetails = Category::categoryDetails($url);
        
        $getProductsIds = Product::select('id')->whereIn('category_id',$catgoryDetails['catIds'])->pluck('id')->toArray();
        $getProductColors = Product::select('product_color')->whereIn('id',$getProductsIds)->groupBy('product_color')->pluck('product_color')->toArray();

        // echo "<pre>"; print_r($getProductColors); die;
        return $getProductColors;
    }

    public static function getBrands($url){
        $catgoryDetails = Category::categoryDetails($url);
        
        $getProductsIds = Product::select('id')->whereIn('category_id',$catgoryDetails['catIds'])->pluck('id')->toArray();
        $brandIDs = Product::select('brand_id')->whereIn('id',$getProductsIds)->pluck('brand_id')->toArray();
        $brandDetails = Brand::select('id','name')->whereIn('id',$brandIDs)->get()->toArray();

        // echo "<pre>"; print_r($brandDetails); die;
        return $brandDetails;
    }

}
