<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = 'root3';
        $user->password = 'r00t';
        $user->first_name = 'admin';
        $user->last_name = 'admin';
        $user->is_active = 1;
        $user->user_role = User::roles['ADMIN'];
        $user->save();   
    }
}
