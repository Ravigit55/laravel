<?php

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        Transaction::create([
            'member_id' => 1,
            'purchase_amount' => 100,
            'points_earned' => 10,
            'description' => 'Grocery Purchase'
        ]);

        Transaction::create([
            'member_id' => 2,
            'purchase_amount' => 50,
            'points_earned' => 5,
            'description' => 'Clothing Purchase'
        ]);
    }
}

