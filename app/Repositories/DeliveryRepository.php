<?php

namespace App\Repositories;

use App\Models\Delivery;
use Illuminate\Support\Collection;

class DeliveryRepository
{
    public function activeDeliveries(): Collection
    {
        return Delivery::where('is_active', true)->get();
    }

}