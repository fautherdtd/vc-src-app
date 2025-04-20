<?php

namespace App\Console\Commands;

use App\Models\PosifloraOrder;
use Illuminate\Console\Command;
use App\Services\Posiflora\PosifloraClient;
use App\Services\Posiflora\PosifloraService;

class FetchPosifloraOrders extends Command
{
    protected $signature = 'posiflora:orders';

    protected $description = 'Fetch and display Posiflora orders filtered by payment method';

    public function handle()
    {
        $this->info('Authenticating with Posiflora...');

        try {
            $client = new PosifloraClient();
            $client->sessionStart();

            $service = new PosifloraService($client);
            $orders = $service->getOrderList();

            $data = collect($orders['data'])->map(function ($order) {
                return [
                    'uid' => $order['id'],
                    'docNo' => $order['attributes']['docNo'],
                    'amount' => $order['attributes']['totalAmount'],
                ];
            })->toArray();


            $uids = $data->pluck('uid')->all();
            $existingUids = PosifloraOrder::whereIn('uid', $uids)->pluck('uid')->all();
            $newRecords = $data->reject(function ($item) use ($existingUids) {
                return in_array($item['uid'], $existingUids);
            });
            if ($newRecords->isNotEmpty()) {
                PosifloraOrder::insert($newRecords->toArray());
            }

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }

        return 0;
    }
}
