<?php

namespace App\Services\Posiflora;

use App\Models\PosifloraOrder;
use App\Services\Payment\PaymentHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PosifloraService extends PosifloraClient
{
    private PosifloraClient $client;

    public function __construct(PosifloraClient $client)
    {
        $this->client = $client;
    }

    /**
     * Получить список заказов по методу оплаты
     * @return array
     * @throws \Exception
     */
    public function getOrderList(): array
    {
        $query = http_build_query(['filter' => [
            'statuses' => 'new'
        ]]);
        $endpoint = "orders?$query";
        return $this->client->getSomeProtectedResource($endpoint);
    }

    /**
     * @param string $orderId
     * @param string $newStatus
     * @return array
     * @throws \Exception
     */
    public function updateOrderStatus(string $orderId, string $newStatus): array
    {
        $endpoint = "orders/{$orderId}";

        $payload = [
            'data' => [
                'type' => 'orders',
                'id' => $orderId,
                'attributes' => [
                    'status' => $newStatus,
                ],
            ],
        ];

        return $this->client->patchResource($endpoint, $payload);
    }

    /**
     * @param string $id
     * @param int $amount
     */
    public function createPaymentForOrder(string $id, int $amount)
    {
        $client = new PaymentHandler();
        $result = $client->client->createPayment([
            'amount' => [
                'value' => $amount,
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
            'description' => 'posiflora:'.$id
        ], uniqid('', true));

        return $result->confirmation->confirmation_url;
    }

    public function createLinkAndMessageTelegramHook(array $order): void
    {
        // Получаем ссылку на оплату
        $link = $this->createPaymentForOrder($order['uid'], $order['amount']);
        PosifloraOrder::where('uid', $order['uid'])
            ->update([
                'payment' => $link,
                'status' => 'process'
            ]);
        // Отправляем в телеграм
        $message = view('docs.telegram', [
            'docNo' => $order['docNo'],
            'amount' => $order['amount'],
            'src' => 'https://valscvetovv.posiflora.com/admin/' . $order['links']['self'],
            'link' => $link
        ])->render();
        $this->sendInfoTelegram($message);
    }

    protected function sendInfoTelegram(string $message): void
    {
        $getQuery = [
            "chat_id" => -4785307407,
            "text" => $message,
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
     * @throws \Exception
     */
    public function webhookTransactionSuccess(string $id) {
        $status = 'assembled';
        PosifloraOrder::where('uid', $id)
            ->update([
                'status' => 'done',
            ]);
        $response = $this->updateOrderStatus($id, $status);
        if ($response['data']['attributes']['status'] != $status) {
            $message = 'Не удалось изменить статус после успешной оплаты для заказа ' . $id;
            $this->sendInfoTelegram($message);
        }
    }
}
