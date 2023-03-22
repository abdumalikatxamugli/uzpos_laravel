<?php

namespace Database\Seeders;

use App\Models\Point;
use App\Models\User;
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
        $shop = new Point();
        $shop->name = 'Head Office';
        $shop->save();

        $user = new User();
        $user->username = 'owner';
        $user->password = 'owner';
        $user->first_name = 'admin';
        $user->last_name = 'admin';
        $user->is_active = 1;
        $user->user_role = User::roles['ADMIN'];
        $user->division_id = $shop->id;
        $user->save(); 

        // $user = new User();
        // $user->username = 'root3';
        // $user->password = 'r00t';
        // $user->first_name = 'admin';
        // $user->last_name = 'admin';
        // $user->is_active = 1;
        // $user->user_role = User::roles['ADMIN'];
        // $user->save(); 
        
        // $shop = new Point();
        // $shop->name = 'sklad';
        // $shop->save();

        // $user = new User();
        // $user->username = 'sklad';
        // $user->password = 'sklad';
        // $user->first_name = 'sklad';
        // $user->last_name = 'sklad';
        // $user->is_active = 1;
        // $user->point_id = $shop->id;
        // $user->user_role = User::roles['WAREHOUSE_MANAGER'];
        // $user->save();
        
        // $shop = new Point();
        // $shop->name = 'sklad2';
        // $shop->save();

        // $user = new User();
        // $user->username = 'sklad2';
        // $user->password = 'sklad2';
        // $user->first_name = 'sklad2';
        // $user->last_name = 'sklad2';
        // $user->is_active = 1;
        // $user->point_id = $shop->id;
        // $user->user_role = User::roles['WAREHOUSE_MANAGER'];
        // $user->save();

        // $shop = new Point();
        // $shop->name = 'sklad3';
        // $shop->save();

        // $user = new User();
        // $user->username = 'sklad3';
        // $user->password = 'sklad3';
        // $user->first_name = 'sklad3';
        // $user->last_name = 'sklad3';
        // $user->is_active = 1;
        // $user->point_id = $shop->id;
        // $user->user_role = User::roles['WAREHOUSE_MANAGER'];
        // $user->save();
    }
}
