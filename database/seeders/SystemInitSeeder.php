<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Point;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemInitSeeder extends Seeder
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

        $currency = new Currency();
        $currency->name = 'Доллар';
        $currency->save();

        $currency = new Currency();
        $currency->name = 'Сум';
        $currency->save();
    }
}
