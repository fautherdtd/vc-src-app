<?php

namespace App\Services\Telegram;

use App\Models\PosifloraOrder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class TelegramSenderService
{
    public function sendOrder(PosifloraOrder $order): void
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = -4785307407;

        $callbackData = (string) $order->id;

        $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => "🛒 Новый заказ #{$order->docNo}\n💵 Сумма: {$order->amount} ₽",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        [
                            'text' => 'Сформировать платёж',
                            'callback_data' => $callbackData
                        ]
                    ]
                ]
            ]),
        ]);

        $data = $response->json();

        if (isset($data['ok']) && $data['ok']) {
            $order->update([
                'telegram_message_id' => $data['result']['message_id'],
            ]);
        } else {
            logger()->error('Ошибка отправки в Telegram', [
                'response' => $data
            ]);
        }
    }

    public function updateOrder(PosifloraOrder $order)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        Http::post("https://api.telegram.org/bot{$token}/editMessageText", [
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'message_id' => $order->telegram_message_id,
            'text' => "✅ Заказ #{$order->doc_no} успешно оплачен.\n💵 Сумма: {$order->amount} ₽",
        ]);
    }
}
