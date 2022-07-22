<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    //Admin Login
    Route::match(['get','post'],'login','AdminController@login');
    Route::group(['middleware'=>['admin']], function(){
        //Admin Dashboard
        Route::get('dashboard','AdminController@dashboard');
        //Admin Password
        Route::match(['get','post'],'update-admin-password','AdminController@updateAdminPassword');
        //Admin Password Check
        Route::post('check-admin-password','AdminController@checkAdminPassword');
        //Admin Logout
        Route::get('logout','AdminController@logout');
        //Admin Details
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');  
        //Vendor Details
        Route::match(['get','post'],'update-vendor-details/{slug}','AdminController@updateVendorDetails');
        //View Admin / Subadmin/ Vendor 
        Route::get('admins/{type?}','AdminController@admins');

        //View Vendor Details
        Route::get('view-vendor-details/{id}','AdminController@ViewVendorDetails');
        //Admin Status
        Route::post('update-admin-status','AdminController@updateAdminStatus');

        //Section
        Route::get('sections','SectionController@section');

        //Section Status
        Route::post('update-section-status','SectionController@updateSectionStatus');

        //Section Delete
        Route::get('delete-section/{id}','SectionController@deleteSection');
        //Section Edit
        //::get('add-edit-section','SectionController@addEditSection');
        Route::match(['get','post'],'add-edit-section/{id?}','SectionController@addEditSection');

        //Brand
        Route::get('brands','BrandController@brand');

        //Brand Status
        Route::post('update-brand-status','BrandController@updateBrandStatus');

        //Brand Delete
        Route::get('delete-brand/{id}','BrandController@deleteBrand');
        //Brand Edit
        //::get('add-edit-Brand','BrandController@addEditBrand');
        Route::match(['get','post'],'add-edit-brand/{id?}','BrandController@addEditBrand');

        //Category
        Route::get('categories','CategoryController@categories');

        //Category Status
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        //Category Add or Edit
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');

        // Category Append Level
        Route::get('append-categories-level','CategoryController@appendCategoryLevel');

        //Category Delete
        Route::get('delete-category/{id}','CategoryController@deleteCategory');

        //Category Image Delete
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');

        //Product
        Route::get('products','ProductController@products');

        //Product Status
        Route::post('update-product-status','ProductController@updateProductStatus');

        //Product Delete
        Route::get('delete-product/{id}','ProductController@deleteProduct');

        //Product Add or Edit
        Route::match(['get','post'],'add-edit-product/{id?}','ProductController@addEditProduct');

        //Product Image Delete
        Route::get('delete-product-image/{id}','ProductController@deleteProductImage');

        //Product Video Delete
        Route::get('delete-product-video/{id}','ProductController@deleteProductVideo');

        //Product Attribute Add
        Route::match(['get','post'],'add-attributes/{id?}','ProductController@addProductAttribute');
        
    });
});

