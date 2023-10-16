<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Categories\CategoriesResources;
use App\Models\Category;

class Categories extends Controller
{
    /**
     * @return CategoriesResources
     */
    public function index(): CategoriesResources
    {
        $categories = Category::where('is_visible', true)
            ->orderBy('position', 'DESC');
        return new CategoriesResources($categories->get());
    }
}
