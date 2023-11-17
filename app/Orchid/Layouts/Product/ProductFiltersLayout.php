<?php

namespace App\Orchid\Layouts\Product;

use App\Orchid\Filters\CategoryFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ProductFiltersLayout extends Selection
{
    /**
     * @return string[]|Filter[]
     */
    public function filters(): array
    {
        return [
            CategoryFilter::class,
        ];
    }
}
