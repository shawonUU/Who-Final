<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
        	'hrs_id'        => 301,
        	'name'          => 'Mr. User 1',
            // 'email'         => 'user1@gmail.com',
            'phone'         => '01900000001',
            'gender'        => 1,
            'designation'   => 1,
            'organization'   => 'Dhaka Medical College',
            'age'           =>'25',
            'division_id'   =>6,
            'district_id'   =>47,
            'upazila_id'    =>365,
            'last_login_at' => Carbon::now(),
            'password'      => Hash::make(1234),
            'status'        => 'active',
            'created_at' => Carbon::now(),
        ],
        [
        	'hrs_id'        => 302,
        	'name'          => 'Mr. User 2',
            // 'email'         => 'user2@gmail.com',
            'phone'         => '01900000002',
            'gender'        => 1,
            'designation'   => 1,
            'organization'   => 'Dhaka Medical College',
            'age'           =>'25',
            'division_id'   =>6,
            'district_id'   =>47,
            'upazila_id'    =>365,
            'last_login_at' => Carbon::now(),
            'password'      => Hash::make(1234),
            'status'        => 'active',
            'created_at' => Carbon::now(),
        ]
    ]);
    }
}
