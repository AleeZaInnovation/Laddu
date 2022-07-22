<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail;

class VendorsBankDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $vendorBankDetailRecords = [
            ['id'=>1,'vendor_id'=>1, 'account_holder_name'=> 'Alee Baba', 'bank_name'=>'DBBL', 
            'account_number'=>'121101226253','bank_ifsc_code'=> '221133'],

        ];
        VendorsBankDetail::insert($vendorBankDetailRecords);
    }
}
