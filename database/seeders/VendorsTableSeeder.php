<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $vendorRecords = [
            ['id'=>1,'name'=>'Vendor Admin', 'address'=> 'Lamabazar', 'city'=>'Sylhet', 
            'state'=>'Sylhet','country'=> 'BD','pincode'=> '11111','mobile'=>'99999999999',
            'email'=>'vendor@vendor.com','status'=>1],

        ];
        Vendor::insert($vendorRecords);
    }
}
