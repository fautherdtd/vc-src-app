<?php

namespace App\Services\Payment;

use App\Jobs\StorageIRL;
use App\Jobs\TelegramOrder;
use App\Models\Order;
use App\Models\PosifloraOrder;
use App\Models\Transactions;
use App\Services\Posiflora\PosifloraClient;
use App\Services\Posiflora\PosifloraService;
use App\Services\Smsc\Smsc;
use App\Services\Telegram\TelegramSenderService;
use Illuminate\Http\Request;
use InvalidArgumentException;
use YooKassa\Client;

class PaymentHandler
{
    public $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuth(
            '261889',
            'live_dN4MtZ1lsgisJx2VuG0FEqVoLjuQn6tW_o3ZFVqXsCY'
        );
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $result = $this->client->createPayment(
            [
                'amount' => [
                    'value' => $data['amount'],
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
                'description' => 'website:'.$data['description']
            ],
            uniqid('', true)
        );
        $this->saveTransactions([
            'id' => $result->id,
            'amount' => $result->amount->value,
            'payment_method' => 'unknown',
            'order_id' => $data['description'],
        ]);

        return $result->confirmation->confirmation_url;
    }

    /**
     * @throws \Exception
     */
    public function webhookTransaction(Request $request)
    {
        if ($request->input('object.status') === 'succeeded') {
            if (empty($request->input('object.description')) || !str_contains($request->input('object.description'), ':')) {
                logger()->error('Webhook error: invalid description', $request->input('object.description'));
                return response()->json(['ok' => true]);
            }

            [$type, $id] = explode(':', $request->input('object.description'), 2);

            if (!in_array($type, ['posiflora', 'website'])) {
                throw new InvalidArgumentException("Unknown source type: $type");
            }

            if ($type == 'posiflora') {
                $this->successForPosiflora($id);
            }

            if ($type == 'website') {
                $this->successForWebSite($request, $id);
            }
        }
    }

    /**
     * @throws \Exception
     */
    protected function successForPosiflora(string $id)
    {
        $posiflora = new PosifloraService(
            new PosifloraClient()
        );
        $order = PosifloraOrder::where('external_uid', $id)->first();
        $telegram = new TelegramSenderService();

        if (!$order) {
            throw new \Exception("Order not found for external_id: {$id}");
        }

        $order->update([
            'status' => 'paid',
        ]);

        $telegram->updateOrder($order);
        $posiflora->updateOrderStatus($id, 'assembled');
    }
    protected function successForWebSite(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        Order::where('number', (int) $id)
            ->update([
                'is_payment' => true
            ]);
        Transactions::where('uuid', $request->input('object.id'))
            ->update([
                'payment_method' => $request->input('object.payment_method.type'),
            ]);
        $order = Order::where('number', (int) $id)
            ->first();
        (new Smsc())->make([
            'phone' => $order['buyer']['phone'],
            'message' => "Заказ #". $id ." оформлен. С уважением, Вальс цветов!",
        ]);
        TelegramOrder::dispatch($id);
        StorageIRL::dispatch($id);
        return response()->json();
    }

    /**
     * @param $data
     */
    public function saveTransactions($data): void
    {
        $model = new Transactions();
        $model->uuid = $data['id'];
        $model->amount = (int) $data['amount'];
        $model->payment_method = $data['payment_method'];
        $model->order_id = $data['order_id'];
        $model->save();
    }
}
