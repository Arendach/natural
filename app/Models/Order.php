<?php

namespace App\Models;

use App\Models\Traits\PhoneFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Order extends Model
{
    use PhoneFormatter,
        AsSource,
        Filterable;

    protected $guarded = [];
    protected $table = 'orders';
    protected $dates = ['accepted_at'];

    public function accepted(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['count', 'price']);
    }
}
