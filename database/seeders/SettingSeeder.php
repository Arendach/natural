<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        if (!Setting::where('title', 'Номери адміністраторів')->exists()) {

            Setting::create([
                'title'   => 'Номери адміністраторів',
                'hash'    => md5('Номери адміністраторів'),
                'content' => '+380964456851,+380666817731',
            ]);

        }
    }
}