<?php

use App\Models\AdminUser;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        AdminUser::create([
            'username' => 'admin',
            'password' => bcrypt('admin123')
        ]);
    }
}

