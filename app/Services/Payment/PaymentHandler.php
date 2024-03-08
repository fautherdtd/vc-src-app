<?php

namespace App\Services\Payment;

use App\Jobs\StorageIRL;
use App\Jobs\TelegramOrder;
use App\Models\Order;
use App\Models\Transactions;
use App\Services\Smsc\Smsc;
use Illuminate\Http\Request;
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
                'capture' => true,
                'description' => $data['description']
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

    public function webhookTransaction(Request $request)
    {
        if ($request->input('object.status') === 'succeeded') {
            Order::where('number', (int) $request->input('object.description'))
                ->update([
                    'is_payment' => true
                ]);
            Transactions::where('uuid', $request->input('object.id'))
                ->update([
                    'payment_method' => $request->input('object.payment_method.type'),
                ]);
            $order = Order::where('number', (int) $request->input('object.description'))
                ->first();
            (new Smsc())->make([
                'phone' => $order['buyer']['phone'],
                'message' => "Заказ #". $request->input('object.description') ." оформлен. С уважением, Вальс цветов!",
            ]);
            TelegramOrder::dispatch($request->input('object.description'));
            StorageIRL::dispatch($request->input('object.description'));
            return response()->json();
        }
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
