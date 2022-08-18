<?php

namespace Database\Seeders;

use App\Models\Delivery;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    public function run(): void
    {
        $this->makeCourierDelivery();

        $this->makeNovaPoshtaDelivery();
    }

    private function makeCourierDelivery(): void
    {
        if (!Delivery::where('slug', 'courier')->exists()) {
            Delivery::create([
                'title'       => "Кур'єр",
                'slug'        => 'courier',
                'description' => "<p>Доставка Кур'єром</p>",
                'picture'     => '/icons/courier.png',
                'is_active'   => true,
            ]);
        }
    }

    private function makeNovaPoshtaDelivery(): void
    {
        if (!Delivery::where('slug', 'nova_poshta')->exists()) {
            Delivery::create([
                'title'       => 'Нова Пошта',
                'slug'        => 'nova_poshta',
                'description' => '<p>Доставка Новою Поштою</p>',
                'picture'     => '/icons/nova_poshta.png',
                'is_active'   => true,
            ]);
        }
    }
}