<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Validator;
use App\Models\Vendor;
use App\Models\Admin;
use DB;

class VendorController extends Controller
{
    //
    public function loginRegistration(){
        return view('front.vendors.login_registration');
    }

    public function vendorRegistration(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data);

            // echo "<pre>"; print_r($data); die;

            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:admins|unique:vendors',
                'mobile' => 'required|min:11|numeric|unique:admins|unique:vendors',
                'accept' => 'required',
            ];

            $customesMessages = [
                'name.required' => 'Name  is required !',
                'email.required' => 'Email  is required !',
                'email.unique' => 'Email  already exists !',
                'mobile.required' => 'Mobile  is required !',
                'mobile.unique' => 'Mobile no  already exists !',
                'accept.required' => 'Please accept T&C !',
            ];

            $validator = Validator::make($data,$rules,$customesMessages);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator);
            }

                DB::beginTransaction();
                
                //Insert Vendor details in vendor table
                $vendor = new Vendor;
                $vendor->name = $data['name'];
                $vendor->email = $data['email'];
                $vendor->mobile = $data['mobile'];
                $vendor->status = 0;

                date_default_timezone_set('Asia/Dhaka');
                $vendor->created_at = date('Y-m-d H:i:s');
                $vendor->updated_at = date('Y-m-d H:i:s');
                $vendor->save();

                $vendor_id = DB::getPdo()->lastInsertId();

                //Insert Vendor details in admin table
                $admin = new Admin;
                $admin->type = 'vendor';
                $admin->vendor_id = $vendor_id;
                $admin->name = $data['name'];
                $admin->email = $data['email'];
                $admin->mobile = $data['mobile'];
                $admin->password = bcrypt($data['password']);
                $admin->status = 0;
                date_default_timezone_set('Asia/Dhaka');
                $admin->created_at = date('Y-m-d H:i:s');
                $admin->updated_at = date('Y-m-d H:i:s');
                $admin->save();

                // Send Email
                $email = $data['email'];
                $messageData = [
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'code' => base64_encode($data['email'])
                ];

                Mail::send('emails.vendor_confirmation',$messageData, function($message)use($email){
                    $message->to($email)->subject('Confirm your account as a vendor');
                });

                DB::commit();

                $message = "Thanks for registering as Vendor. Please confirm your account by email.";

                return redirect()->back()->with('success_message',$message);
        }
    }

    public function confirmVendor($email){
        $email = base64_decode($email); 
        $vendorCount = Vendor::where('email',$email)->count();
        if($vendorCount>0){
            $vendorDetails = Vendor::where('email',$email)->first();
            if($vendorDetails=="Yes"){
                $message = "Your Vendor account is already confirmed. You can login";
                return redirect('vendor/login-registration/')->with('error_message',$message);
            }else{
                Admin::where('email',$email)->update(['confirm'=>'Yes']);
                Vendor::where('email',$email)->update(['confirm'=>'Yes']);
                // Send Email
                
                $messageData = [
                    'email' => $email,
                    'name' => $vendorDetails->name,
                    'mobile' => $vendorDetails->mobile,
                ];

                Mail::send('emails.vendor_confirmed',$messageData, function($message)use($email){
                    $message->to($email)->subject('Your Vendor Account Confirmed');
                });

                $message = "Your vendor email is confirmed. Please log in and add your personal, business and bank details so that your account will get approved .";

                return redirect('vendor/login-registration/')->with('success_message',$message);
            }
        }else{
            abort(404);
        }
    }
}
