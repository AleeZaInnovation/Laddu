<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Brand;

class BrandController extends Controller
{
    //
    public function brand(){
        Session::put('page','brands');
        $brands = Brand::get()->toArray();
        //dd($brands);
        return view('admin.brands.brands')->with(compact('brands'));
    }

    public function updateBrandStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }

            Brand::where('id',$data['item_id'])->update(['status'=>$status]);

            return response()->json(['status'=>$status,'item_id'=>$data['item_id']]);
        }
    }

    public function deleteBrand($id){
        Brand::where('id',$id)->delete();
        $message = "Brand has been deleted successfully .";
        return redirect()->back()->with('success_message',$message);
    }

    public function addEditBrand(Request $request,$id=null){
        Session::put('page','sections');
        if($id==""){
            $title = "Add Brand";
            $brand = new Brand;
            $message = "Brand has been added.";
        }else{
            $title = "Edit Brand";
            $brand = Brand::find($id);
            $message = "Brand has been updated.";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $rules = [
                'brand_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];

            $customesMessages = [
                'brand_name.required' => 'brand name is required !',
                'brand_name.regex' => 'Valid brand name is required !',
            ];

            $this->validate($request,$rules,$customesMessages);

            $brand->name = $data['brand_name'];
            $brand->status = 1;
            $brand->save();

            return redirect('admin/brands')->with('success_message',$message);
        }
        return view('admin.brands.add_edit_brand')->with(compact('title','brand'));
    }
}
