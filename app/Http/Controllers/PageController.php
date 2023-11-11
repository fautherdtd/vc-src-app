<?php

namespace App\Http\Controllers;

use App\Http\Resources\PageResource;
use App\Models\Pages;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    /**
     * @return Response
     */
    public function delivery(): Response
    {
        return Inertia::render('Delivery', [
            'data' => Pages::where('slug', 'delivery')->first()
        ]);
    }

    /**
     * @return Response
     */
    public function payment(): Response
    {
        return Inertia::render('Payment', [
            'data' => Pages::where('slug', 'payment')->first()
        ]);
    }

    /**
     * @return Response
     */
    public function about(): Response
    {
        return Inertia::render('About', [
            'page' => new PageResource(Pages::where('slug', 'about')->first())
        ]);
    }
}
