<?php

namespace App\Console\Commands;

use App\Models\PosifloraOrder;
use App\Services\Posiflora\PosifloraOrderService;
use App\Services\Telegram\TelegramSenderService;
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
                    'external_uid' => $order['id'],
                    'docNo' => $order['attributes']['docNo'],
                    'amount' => $order['attributes']['totalAmount'],
                ];
            });

            $orderService = app(PosifloraOrderService::class);
            $telegramService = app(TelegramSenderService::class);

            foreach ($data as $orderData) {
                $order = $orderService->storeIfNotExists($orderData);

                if ($order->wasRecentlyCreated) {
                    $telegramService->sendOrder($order);
                }
            }

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }

        return 0;
    }
}
