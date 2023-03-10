<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
        	'name'     => 'Mr. Admin',
            'email'    => 'admin@admin.com',
            'phone'    => '01600000001',
            'password' => Hash::make(1234),
            'password' => Hash::make(1234),
            'type'     => 'admin',
            'status'   => 'active'
        ]);
    }
}
