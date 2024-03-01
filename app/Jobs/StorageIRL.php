<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StorageIRL implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $numberID;

    /**
     * Create a new job instance.
     */
    public function __construct(int $numberID)
    {
        $this->numberID = $numberID;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::where('number', $this->numberID)->first();
        foreach ($order->items as $item) {
            if ($item['type'] === 'Product') {
                DB::table('products')
                    ->where('id', $item['product_id'])
                    ->decrement('qty', $item['qty']);
            }
        }
    }
}
