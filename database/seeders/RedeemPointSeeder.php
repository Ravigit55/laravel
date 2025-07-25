<?php

use App\Models\Redemption;
use Illuminate\Database\Seeder;

class RedeemPointSeeder extends Seeder
{
    public function run()
    {
        Redemption::create([
            'member_id' => 1,
            'points_used' => 100,
            'discount_amount' => 5
        ]);

        Redemption::create([
            'member_id' => 2,
            'points_used' => 200,
            'discount_amount' => 10
        ]);
    }
}

