<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void 
     */
    public function run()
    {
        $adminObj = User::where('user_type', 'admin')->first();

        // Admin User Credential
        if (!$adminObj) {
            User::create([
                'first_name' => SUPER_ADMIN_FIRST_NAME,
                'last_name' => SUPER_ADMIN_LAST_NAME,
                'email' => SUPER_ADMIN_EMAIL,
                'password' => bcrypt('123456789'),
                'user_type' => 'admin'
            ]);
            User::create([
                'first_name' => ADMIN_FIRST_NAME,
                'last_name' => ADMIN_LAST_NAME,
                'email' => ADMIN_EMAIL,
                'password' => bcrypt('123456789'),
                'user_type' => 'admin'
            ]);
            User::create([
                'first_name' => DEVELOPER_FIRST_NAME,
                'last_name' => DEVELOPER_LAST_NAME,
                'email' => DEVELOPER_EMAIL,
                'password' => bcrypt('123456789'),
                'user_type' => 'admin'
            ]);
        }

      
       
    }
}
