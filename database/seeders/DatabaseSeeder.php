<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(DeliverySeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(SocialLinkSeeder::class);
    }
}