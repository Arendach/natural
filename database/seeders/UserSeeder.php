<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@admin.com')->exists()) {

            User::create([
                'name'        => 'site admin',
                'email'       => 'admin@admin.com',
                'password'    => Hash::make('admin@admin.com'),
                'permissions' => json_encode([
                    'platform.index'              => 1,
                    'platform.orders'             => 1,
                    'platform.banners'            => 1,
                    'platform.products'           => 1,
                    'platform.settings'           => 1,
                    'platform.categories'         => 1,
                    'platform.systems.roles'      => 1,
                    'platform.systems.users'      => 1,
                    'platform.systems.attachment' => 1,
                ]),
            ]);

        }
    }
}