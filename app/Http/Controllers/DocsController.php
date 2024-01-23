<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\TimeSlots;

class DocsController extends Controller
{
    public function florist(int $id)
    {
        $order = Order::with(['customer', 'items', 'shipping'])
            ->where('id', $id)
            ->first();

        return view('docs/florist', [
            'order' => $order
        ]);
    }

    public function courier($id)
    {
        $slots = TimeSlots::where('is_active', true)->first();
        $order = Order::with(['customer', 'items', 'shipping'])
            ->where('id', $id)
            ->first();
        $slot = [];
        foreach ($slots->slots as $key => $value) {
            $temps = explode("-", $value['Слот']);
            if (in_array($order->delivery_time->format("H:i"), $temps)) {
                $slot = $temps;
            }
        }
        return view('docs/courier', [
            'order' => $order,
            'slot' => $slot
        ]);
    }
}
