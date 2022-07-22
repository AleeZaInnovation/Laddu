<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $adminRecords = [
            ['id'=>1,'name'=>'Super Admin','type'=>'superadmin','vendor_id'=>0,'mobile'=>'11111111111',
            'email'=>'admin@admin.com','password'=>'$2y$10$3euInXheXct7a8wfjP8ewO9ZF.1E6iCQfagprwsZfpOzsPpjkr8Ru',
            'image'=>'','status'=>1],
            ['id'=>2,'name'=>'Vendor Admin','type'=>'vendor','vendor_id'=>1,'mobile'=>'99999999999',
            'email'=>'vendor@vendor.com','password'=>'$2y$10$3euInXheXct7a8wfjP8ewO9ZF.1E6iCQfagprwsZfpOzsPpjkr8Ru',
            'image'=>'','status'=>1],

        ];
        Admin::insert($adminRecords);
    }
}
