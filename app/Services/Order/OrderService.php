<?php

namespace App\Services\Order;

use App\Facades\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function create(array $data): bool
    {
        DB::beginTransaction();
        try {
            $customerID = Customer::create($data['customer']);
            $data['order']['customer_id'] = $customerID;
            $orderID = Order::create($data['order']);

            $items = [];
            foreach (Cart::content() as $key => $item) {
                $items[] = [
                    'order_id' => $orderID,
                    'product_id' => $key,
                    'qty' => $item['quantity'],
                    'unit_price' => $item['price']
                ];
            }
            OrderItems::insert($items);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return array[]
     * @throws \Exception
     */
    public function prepare(Request $request)
    {
        return [
            'order' => [
                'number' => substr(Carbon::now()->unix(), 0, 3) . random_int(0, 999),
                'total_price' => (int) Cart::total(),
                'delivery_time' => $request->input('delivery_time'),
                'shipping_method' => $request->input('delivery.method'),
                'shipping_price' => $request->input('delivery.price'),
                'address' => $request->input('delivery.address'),
                'buyer' => $request->input('contacts.from'),
                'recipient' => $request->input('contacts.to'),
                'notes' => $request->input('message') ?? 'Комментария нет.'
            ],
            'customer' => [
                'name' => $request->input('contacts.from.name'),
                'phone' => $request->input('contacts.from.name.phone')
            ],
            'products' => Cart::content()
        ];
    }

    /**
     * @return mixed
     */
    public function customer(): mixed
    {
        $model = Customer::where('phone', $this->data['contacts']['from']['phone']);
        if ($model->exist()) {
            return Customer::insertGetId([
                'name' => $this->data['contacts']['from']['name'],
                'phone' => $this->data['contacts']['from']['phone']
            ]);
        }
        return $model->first();
    }
}
