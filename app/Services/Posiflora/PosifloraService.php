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
        $query = http_build_query([
            'page' => [
                'size' => 10,
                'number' => 1,
            ],
            'filter' => [
                'stores' => '3275ea5b-8911-4e26-8358-63b6b6706a77',
                'paymentMethods' => '05ca57ae-05fa-472d-ac77-6c605c31d88f',
                'statuses' => 'new,notAccepted',
            ],
            'include' => 'source,store,store.timezone,customer,postedBy,createdBy,lockedBy,payments,payments.method,discounts,courier,florist'
        ]);
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
}
