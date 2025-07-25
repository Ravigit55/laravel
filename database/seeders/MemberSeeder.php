<?php

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run()
    {
        Member::create([
            'name' => 'John Doe',
            'phone' => '9876543210',
            'password' => bcrypt('password123'),
            'points_balance' => 250
        ]);

        Member::create([
            'name' => 'Jane Smith',
            'phone' => '9123456789',
            'password' => bcrypt('password456'),
            'points_balance' => 150
        ]);
    }
}
