<?php

namespace Database\Seeders;

use App\Models\{Role, User};
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        $admin_id = Role::where('name', '=', 'admin')->pluck('id')->first();
        $emp_id = Role::where('name', '=', 'employee')->pluck('id')->first();

        $user1 = User::create([
            'name' => 'Shahmir Khan Jadoon',
            'email' => 'shahmir@gmail.com',
            'slug' => 'shahmir-khan-jadoon-' . time(),
            'password' =>  bcrypt(123456),
            'role_id' => $admin_id,
        ]);

        $user1->save();

        $user2 = User::create([
            'name' => 'Jibran Rahim Khattak',
            'email' => 'jibranrahimktk@gmail.com',
            'slug' => 'jibran-rahim-khattak-' . time(),
            'password' =>  bcrypt(123456),
            'role_id' => $admin_id,
        ]);

        $user2->save();

        $user3 = User::create([
            'name' => 'Shayan Rahim Khattak',
            'email' => 'shayan.rahim96@gmail.com',
            'slug' => 'shayan-rahim-khattak-' . time(),
            'password' =>  bcrypt(123456),
            'role_id' => $admin_id,
        ]);

        $user2->save();        

        $user3 = User::create([
            'name' => 'Shoaib Khan',
            'email' => 'shoaib@gmail.com',
            'slug' => 'shoaib-khan-' . time(),
            'password' =>  bcrypt(123456),
            'role_id' => $emp_id,
        ]);

        $user3->save();

    }
}
