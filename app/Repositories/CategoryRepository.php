<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryRepository
{
    public function getCategoryWithProducts(string $slug): Category
    {
        return Category::where('is_active', true)
            ->where('slug', $slug)
            ->with([
                'products' => fn(HasMany $builder) => $builder->orderByDesc('priority')
            ])
            ->firstOrFail();
    }
}