<?php

namespace Database\Seeders;

use App\Models\Admin;
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
        Admin::create([
            'name'=>'admin',
            'email'=>'admin@admin.com',
            'password'=> bcrypt('123456aa'),
        ]);

        Admin::create([
            'name'=>'user',
            'email'=>'user@user.com',
            'password'=> bcrypt('user1234'),
        ]);
    }
}
