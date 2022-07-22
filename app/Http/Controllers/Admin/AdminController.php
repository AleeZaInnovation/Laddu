<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetail;
use App\Models\VendorsBankDetail;
use App\Models\Country;
use Image;
use Extension;
use Session;

class AdminController extends Controller
{
    //
    public function dashboard(){
        Session::put('page','dashboard');
        return view('admin.dashboard');
    }

    public function login(Request $request){
        //echo $password= Hash::make('123456'); die;
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data);die;
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customesMessages = [
                'email.required' => 'Email is required !',
                'email.email' => 'Valid email is required !',
                'password.required' => 'Password is required !',
            ];
            $this->validate($request,$rules,$customesMessages);

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'], 'status'=>1])){
                return redirect('admin/dashboard');  
                }else{
                    return redirect()->back()->with('error_message','Invalid Email or Password');
                }
            }

            return view('admin.login');
    }
    
    public function logout(){
        Auth::guard('admin')->logout();
        return view('admin.login');
    }
    

    public function updateAdminPassword( Request $request){
        Session::put('page','update_admin_password');
        //echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data);die;
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
                if($data['current_password']==$data['new_password']){
                    return redirect()->back()->with('error_message','New password is not same as current password !');
                } else if ($data['new_password']==$data['confirm_password']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message','Password has been updated !');
                }else {
                    return redirect()->back()->with('error_message','New password is not match with confirm password !');                    
                }
            } else {
                return redirect()->back()->with('error_message','Current Password is Incorrect !');
            }
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function checkAdminPassword(Request $request){
        $data = $request->all();
        //echo "<pre>"; print_r($data); die;
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            return "true";
        } else {
            return "false";
        }
    }

    public function updateAdminDetails( Request $request){
        Session::put('page','update_admin_details');
        //echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
        

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required|numeric',
            ];

            $customesMessages = [
                'name.required' => 'Name is required !',
                'name.regex' => 'Valid name is required !',
                'mobile.required' => 'Mobile no is required !',
                'mobile.numeric' => 'Valid mobile no is required !',
            ];

            $this->validate($request,$rules,$customesMessages);

            if($request->hasFile('image')){
                $image = $request->file('image');
                if($image->isValid()){
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'admin/images/photos/'.$imageName;
                    Image::make($image)->save($imagePath);
                }
            } else if (!empty($data['current_admin_image'])){
                $imageName = $data['current_admin_image'];
               
            } else {
                $imageName = "";
            }
                        
           
            //echo "<pre>"; print_r($data);die;
            Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['name'], 'mobile'=>$data['mobile'], 'image'=>$imageName]);
            return redirect()->back()->with('success_message','Deatils has been updated !');
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_details')->with(compact('adminDetails'));
    }

    public function updateVendorDetails($slug, Request $request){
        if($slug=="personal"){
            Session::put('page','update_personal_details');
            $vendorDetails = Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            if($request->isMethod('post')){
                $data = $request->all();
                //echo "<pre>"; print_r($data); die;
                $rules = [
                    'name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'city' => 'required|regex:/^[\pL\s\-]+$/u',
                    'mobile' => 'required|numeric',
                ];
    
                $customesMessages = [
                    'name.required' => 'Name is required !',
                    'name.regex' => 'Valid name is required !',
                    'city.required' => 'City is required !',
                    'city.regex' => 'Valid city is required !',
                    'mobile.required' => 'Mobile no is required !',
                    'mobile.numeric' => 'Valid mobile no is required !',
                ];
    
                if($request->hasFile('image')){
                    $image = $request->file('image');
                    if($image->isValid()){
                        $extension = $image->getClientOriginalExtension();
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/photos/'.$imageName;
                        Image::make($image)->save($imagePath);
                    }
                } else if (!empty($data['current_vendor_image'])){
                    $imageName = $data['current_vendor_image'];
                   
                } else {
                    $imageName = "";
                }
                            
                $this->validate($request,$rules,$customesMessages);
                //echo "<pre>"; print_r($data);die;
                //Update in Admin Table
                Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['name'], 'mobile'=>$data['mobile'], 'image'=>$imageName]);
                //Update in Vendor Table
                Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->update(['name'=>$data['name'], 'mobile'=>$data['mobile'],'address'=>$data['address'], 'city'=>$data['city'],
                'state'=>$data['state'], 'country'=>$data['country'],'pincode'=>$data['pincode']]);
                return redirect()->back()->with('success_message','Deatils has been updated !');
            }
        }else if($slug=="business"){
            Session::put('page','update_business_details');
            $vendorDetails = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->
                user()->vendor_id)->first()->toArray();
            
                if($request->isMethod('post')){
                    $data = $request->all();
                    //echo "<pre>"; print_r($data); die;
                    $rules = [
                        'shop_name' => 'required|regex:/^[\pL\s\-]+$/u',
                        'shop_city' => 'required|regex:/^[\pL\s\-]+$/u',
                        'shop_mobile' => 'required|numeric',
                        'address_proof' => 'required',
                    ];
        
                    $customesMessages = [
                        'shop_name.required' => 'Shop name is required !',
                        'shop_name.regex' => 'Valid shop name is required !',
                        'shop_city.required' => 'Shop city is required !',
                        'shop_city.regex' => 'Valid shop city is required !',
                        'shop_mobile.required' => 'Shop mobile no is required !',
                        'shop_mobile.numeric' => 'Valid shop mobile no is required !',
                    ];

        
                    if($request->hasFile('address_proof_image')){
                        $image = $request->file('address_proof_image');
                        if($image->isValid()){
                            $extension = $image->getClientOriginalExtension();
                            $imageName = rand(111,99999).'.'.$extension;
                            $imagePath = 'admin/images/proofs/'.$imageName;
                            Image::make($image)->save($imagePath);
                        }
                    } else if (!empty($data['current_proof_image'])){
                        $imageName = $data['current_proof_image'];
                    
                    } else {
                        $imageName = "";
                    }
                                
                    $this->validate($request,$rules,$customesMessages);
                    //echo "<pre>"; print_r($data);die;
                    
                    //Update in Vendor Business Table
                    VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['shop_name'=>$data['shop_name'], 'shop_mobile'=>$data['shop_mobile'],'shop_address'=>$data['shop_address'], 'shop_city'=>$data['shop_city'],
                    'shop_state'=>$data['shop_state'], 'shop_country'=>$data['shop_country'],'shop_pincode'=>$data['shop_pincode'], 
                    'shop_website'=>$data['shop_website'],'shop_email'=>$data['shop_email'], 'address_proof'=>$data['address_proof'],
                    'business_license_number'=>$data['business_license_number'],  'gst_number'=>$data['gst_number'],'pan_number'=>$data['pan_number'],
                    'address_proof_image'=>$imageName]);
                    return redirect()->back()->with('success_message','Deatils has been updated !');
                }
        }else if($slug=="bank"){
            Session::put('page','update_bank_details');
            $vendorDetails = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->
                user()->vendor_id)->first()->toArray();
                if($request->isMethod('post')){
                    $data = $request->all();
                    //echo "<pre>"; print_r($data); die;
                    $rules = [
                        'account_holder_name' => 'required|regex:/^[\pL\s\-]+$/u',
                        'bank_name' => 'required|regex:/^[\pL\s\-]+$/u',
                        'account_number' => 'required|numeric',
                        'bank_ifsc_code' => 'required',
                    ];
        
                    $customesMessages = [
                        'account_holder_name.required' => 'Account holder name is required !',
                        'account_holder_name.regex' => 'Valid account holder name is required !',
                        'bank_name.required' => 'Bank name is required !',
                        'bank_name.regex' => 'Valid bank name is required !',
                        'account_number.required' => 'Account number is required !',
                        'account_number.numeric' => 'Valid account number is required !',
                        'bank_ifsc_code.required' => 'Bank IFSC code is required !',
                    ];
                                
                    $this->validate($request,$rules,$customesMessages);
                    //echo "<pre>"; print_r($data);die;
                    
                    //Update in Vendor Bank Table
                    VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name'=>$data['account_holder_name'], 
                    'bank_name'=>$data['bank_name'],'account_number'=>$data['account_number'], 'bank_ifsc_code'=>$data['bank_ifsc_code']]);
                    return redirect()->back()->with('success_message','Deatils has been updated !');
                }
        }
        $countires= Country::where('status',1)->get();
        return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails','countires'));

    }

    public function admins($type=null){
        $admins =Admin::query();
        if(!empty($type)){
            $admins = $admins->where('type',$type);
            $title = ucfirst($type)."s";
            Session::put('page','view_'.strtolower($title));
        }else{
            $title = "All Admins/Subadmins/Vendors";
            Session::put('page','view_all');
        }
        $admins = $admins->get()->toArray();
        return view('admin.admins.admins')->with(compact('admins','title'));
    }

    public function ViewVendorDetails($id){
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id',$id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails),true);
        //dd($vendorDetails);
        return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));
    }

    public function updateAdminStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }

            Admin::where('id',$data['item_id'])->update(['status'=>$status]);

            return response()->json(['status'=>$status,'item_id'=>$data['item_id']]);
        }
    }

}
