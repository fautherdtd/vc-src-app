<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Http\Controllers\Helpers\Images;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\Delivery\DeliveryResources;
use App\Http\Resources\Payments\PaymentsResources;
use App\Facades\Order;
use App\Jobs\TelegramOrder;
use App\Models\Payment;
use App\Models\Postcards;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\TimeSlots;
use App\Services\Order\OrderService;
use App\Services\Payment\PaymentHandler;
use App\Services\Smsc\Smsc;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Watson\Active\Route;

class CartController extends Controller
{
    use Images;

    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Cart/Index');
    }

    /**
     * @return Response
     */
    public function order(): Response
    {
        $delivery = Shipping::where('is_active', true)->get();
        $payments = Payment::where('is_active', true)->get();
        return Inertia::render('Cart/Order', [
            'delivery' => new DeliveryResources($delivery),
            'payments' => new PaymentsResources($payments)
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSlotsTime(Request $request): \Illuminate\Http\JsonResponse
    {
        $carbonDay = Carbon::create($request->input('date') . date('H:i'));
        $model = TimeSlots::where('is_active', true)->first();
        $slots = [];
        foreach ($model->slots as $key => $value) {
            $slots[] = $value['Слот'];
        }

        if ($carbonDay->format('Y-m-d') !== Carbon::now()->format('Y-m-d')) {
            return response()->json($slots);
        } else {
            $start = $carbonDay->addHour()->roundHour()->format('H:i');
            foreach ($slots as $key => $slot) {
                $item = explode('-', $slot);
                if (!empty($item[1])) {
                    if (strtotime($start) > strtotime($item[0])
                        && strtotime($start) > strtotime($item[1])) {
                        unset($slots[$key]);
                    }
                } else {
                    if (strtotime($start) > strtotime($item[0])) {
                        unset($slots[$key]);
                    }
                }

            }
            return response()->json(array_values($slots));
        }
    }

    /**
     * @param StoreOrderRequest $request
     * @throws \Exception
     * @throws GuzzleException
     */
    public function create(StoreOrderRequest $request, OrderService $service)
    {
        $data = $service->prepare($request);
        $order = $service->create($data);
        (new Smsc())->make([
            'phone' => $data['customer']['phone'],
            'message' => "Заказ #". $data['order']['number'] ." оформлен. С уважением, Вальс цветов!",
        ]);
//        TelegramOrder::dispatch($data['order']['number']);
        if ($request->input('payment.method') === 'online-card' && $order) {
            $transaction = new PaymentHandler();
            $result = $transaction->create([
                'amount' => $data['order']['total_price'],
                'description' => $data['order']['number'],
            ]);
            Cart::clear();
            return Inertia::location($result);
        }
        Cart::clear();
    }

    /**
     * Adds an item to cart.
     *
     * @param Request $request
     */
    public function addToCart(Request $request)
    {
        $product = $request->input('type') === 'product' ?
            Product::with('category')->find($request->input('id')) :
            Postcards::with('category')->find($request->input('id'));

        Cart::add(
            $request->input('id'),
            $product->name,
            $request->input('price'),
            $request->count ?? 1,
            [
                'type' => $request->type,
                'category' => $product->category->name,
                'image' => $this->getUrl($product->attachment(
                    $request->input('type') === 'product' ? 'preview' : 'postcards'
                )->first()),
                'modify' => $request->input('modify') ?? []
            ]
        );
    }

    /**
     * @param Request $request
     * @return void
     */
    public function updateToCart(Request $request)
    {
        Cart::update($request->input('id'), $request->input('action'));
    }
}
