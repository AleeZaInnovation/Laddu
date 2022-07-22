<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail;

class VendorsBusinessDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $vendorsBusinessDetailRecords = [
            ['id'=>1,'vendor_id'=>1,'shop_name'=>'Abcd Shop', 'shop_address'=> 'Lamabazar', 'shop_city'=>'Sylhet', 
            'shop_state'=>'Sylhet','shop_country'=> 'BD','shop_pincode'=> '11111','shop_mobile'=> '77777777777','shop_website'=>'www.abcshop.com',
            'shop_email'=>'vendor@vendor.com','address_proof'=>'Passport',
            'address_proof_image'=>'test.jpg','business_license_number'=>'98765432',
            'gst_number'=>'2345678','pan_number'=>'8765432'],

        ];
        VendorsBusinessDetail::insert($vendorsBusinessDetailRecords);
    }
}
