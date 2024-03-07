<?php

namespace App\Jobs;

use App\Http\Controllers\Helpers\Images;
use App\Models\Order;
use App\Services\Order\TimeSlots;
use Carbon\Carbon;
use CURLFile;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TelegramOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Images;

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
        $slot = new TimeSlots();
        $message = view('docs.telegram', [
            'order' => $order,
            'date' => Carbon::parse($order->delivery_time)->format('y-m-d'),
            'slot' => $slot->slotTimeRange($order->delivery_time)
        ])->render();
        $this->sendInfoOrder($message);
        $this->sendFile($order);
    }

    /**
     * @param string $text
     * @return void
     */
    protected function sendInfoOrder(string $text): void
    {
        $getQuery = [
            "chat_id" => -1002032850753,
            "text" => $text,
            "parse_mode" => "html"
        ];
        $ch = curl_init("https://api.telegram.org/bot6411993510:AAEXUmjb3VeVrvV4vOMcbS5rqYyOpyla_Z4/sendMessage?" . http_build_query($getQuery));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_exec($ch);
        curl_close($ch);
    }

    /**
     * @param Order $orders
     */
    public function sendFile(Order $order)
    {
        $arrayQuery = [
            'chat_id' => -1002032850753,
        ];
        $media = [];
        foreach ($order->items as $item) {
            $attach = $item->{strtolower($item->type)}->attachment->first();
            $name = $attach->name . '.' . $attach->extension;
            $media[] = ['type' => 'photo', 'media' => 'attach://' . $name];
            $arrayQuery[$name] = new CURLFile(
                Storage::disk('public')->url($attach->path . $name)
            );
        }
        $arrayQuery['media'] = json_encode($media);
        $ch = curl_init('https://api.telegram.org/bot6411993510:AAEXUmjb3VeVrvV4vOMcbS5rqYyOpyla_Z4/sendMediaGroup');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayQuery);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
    }
}
