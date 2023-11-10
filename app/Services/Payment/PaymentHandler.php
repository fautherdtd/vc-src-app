<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Transactions;
use Illuminate\Http\Request;
use YooKassa\Client;

class PaymentHandler
{
    public $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuth(
            '278498',
            'test_FvPDF_U2g6Ao05xVXKE5QEgDY72RpAM-Aclibdu0C6I'
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
        $model = Transactions::where('uuid', $request->input('object.id'))->first();
        $model->uuid = $request->input('object.id');
        $model->amount = $request->input('amount.value');
        $model->payment_method = $request->input('payment_method.type');
        $model->order_id = $request->input('object.description');
        $model->save();
        if ($request->input('object.status') === 'succeeded') {
            Order::where('id', $request->input('object.description'))
                ->update([
                    'is_payment' => true
                ]);
        }
        $guzzle = new \GuzzleHttp\Client();
        $guzzle->get($request->url());
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
