<?php

namespace App\Http\Controllers;

use App\Models\PosifloraOrder;
use App\Services\Payment\PaymentHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;


class TelegramController extends Controller
{
    public function handleCallback(Request $request)
    {
        $callbackQuery = $request->input('callback_query');

        if (!$callbackQuery) {
            return response()->json(['ok' => true]);
        }

        try {
            $data = $callbackQuery['data'];
            $orderId = (int) $data; // Просто приводим к integer
            $order = PosifloraOrder::findOrFail($orderId);

            // Генерация ссылки на оплату
            $paymentUrl = $this->generatePaymentUrl($order);

            $order->update([
                'status' => 'awaiting_payment',
                'payment_url' => $paymentUrl,
            ]);

            // Новый текст: добавляем ссылку, сохраняем кнопку
            $newText = "🛒 Заказ #{$order->external_uid}\n" .
                "💵 Сумма: {$order->amount} ₽\n\n" .
                "🔗 Ссылка для оплаты:\n{$paymentUrl}";

            $token = env('TELEGRAM_BOT_TOKEN');

            // Теперь обновляем сообщение, но оставляем кнопку
            Http::post("https://api.telegram.org/bot{$token}/editMessageText", [
                'chat_id' => $callbackQuery['message']['chat']['id'],
                'message_id' => $callbackQuery['message']['message_id'],
                'text' => $newText,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            [
                                'text' => 'Сформировать платёж',
                                'callback_data' => $data // ту же кнопку оставляем
                            ]
                        ]
                    ]
                ]),
            ]);

            // Ответ на callback, чтобы убрать крутилку
            Http::post("https://api.telegram.org/bot{$token}/answerCallbackQuery", [
                'callback_query_id' => $callbackQuery['id'],
                'text' => 'Ссылка на оплату добавлена ✅',
            ]);

        } catch (\Exception $e) {
            logger()->error('Ошибка в Telegram Callback', [
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json(['ok' => true]);
    }

    private function generatePaymentUrl(PosifloraOrder $order): string
    {
        $client = new PaymentHandler();
        $result = $client->client->createPayment([
            'amount' => [
                'value' => $order->amount,
                'currency' => 'RUB',
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => route('index')
            ],
            'payment_method_data' => [
                'type' => 'bank_card',
                'type' => 'sbp'
            ],
            'capture' => true,
            'description' => 'posiflora:'.$order->external_uid
        ], uniqid('', true));

        return $result->confirmation->confirmation_url;
    }
}
