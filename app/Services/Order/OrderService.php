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
        return DB::transaction(function()  use($data) {
            $data['order']['customer_id'] = $this->customer($data['customer']);
            $orderID = Order::create($data['order']);

            $items = [];
            foreach (Cart::content() as $key => $item) {
                $items[] = [
                    'order_id' => $orderID->id,
                    'product_id' => $key,
                    'qty' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'type' => ucwords($item['options']['type'])
                ];
            }
            OrderItems::insert($items);
            return true;
        });
    }

    /**
     * @param Request $request
     * @return array[]
     * @throws \Exception
     */
    public function prepare(Request $request): array
    {
        $slot = function ($value) {
            return preg_replace("/\?.+/", "", $value);
        };
        return [
            'order' => [
                'number' => substr(Carbon::now()->unix(), 0, 3) . random_int(0, 999),
                'total_price' =>
                    (int) $request->input('total') === 0 ? Cart::total() : $request->input('total'),
                'delivery_time' => $request->input('timeDelivery.date') . ' ' . $slot($request->input('timeDelivery.time')),
                'shipping_method' => $request->input('delivery.method'),
                'shipping_price' => $request->input('delivery.price'),
                'address_sub' => $request->input('delivery.sub'),
                'address' => $this->getAddress($request),
                'buyer' => $request->input('contacts.from'),
                'recipient' => $request->input('contacts.to') ?? $request->input('contacts.from'),
                'notes' => $request->input('message') ?? 'Комментария нет.',
                'anonymous' => $request->input('anonymous')
            ],
            'customer' => [
                'name' => $request->input('contacts.from.name'),
                'phone' => $request->input('contacts.from.phone')
            ],
            'products' => Cart::content()
        ];
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function getAddress(Request $request): string
    {
        if ($request->input('delivery.method' === 'self')) {
            return 'Самовывоз';
        }
        return $request->input('delivery.address') ?? "Узнать самостоятельно у получателя.";
    }

    /**
     * @param $contacts
     * @return mixed
     */
    public function customer($contacts): mixed
    {
        $model = Customer::where('phone', $contacts['phone'])->first();
        if (! $model) {
            return Customer::insertGetId([
                'name' => $contacts['name'],
                'phone' => $contacts['phone'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        return $model->id;
    }

    public function confirmationInStock()
    {

    }
}
