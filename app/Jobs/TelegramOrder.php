<?php

namespace App\Jobs;

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TelegramOrder implements ShouldQueue
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
        $client = new Client([
            'base_uri' => 'https://api.telegram.org/bot6411993510:AAEXUmjb3VeVrvV4vOMcbS5rqYyOpyla_Z4/',
            'timeout'  => 2.0,
        ]);
        $client->get('sendMessage', [
            'query' => [
                'chat_id' => -4040710684,
                'text'  => 'Поступил заказ №'. $this->numberID .'. <a href="https://valscvetov.ru/admin/order/show/'. $order->id .'">Информация о заказе</a>',
                'parse_mode' => 'html'
            ]
        ]);
    }
}
