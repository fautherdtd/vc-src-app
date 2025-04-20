<?php

namespace App\Console\Commands;

use App\Models\PosifloraOrder;
use App\Services\Posiflora\PosifloraClient;
use App\Services\Posiflora\PosifloraService;
use Illuminate\Console\Command;

class PosifloraOrdersTransaction extends Command
{
    protected $signature = 'posiflora:orders-transactions';

    protected $description = 'Posiflora orders transactions';

    public function handle()
    {
        $orders = PosifloraOrder::where('status', 'new')->all();

        $client = new PosifloraClient();
        $service = new PosifloraService($client);

        foreach ($orders as $order) {
            $service->createLinkAndMessageTelegramHook([
                'uid' => $order->uid,
                'docNo' => $order->docNo,
                'amount' => $order->amount,
            ]);
        }
    }

}
