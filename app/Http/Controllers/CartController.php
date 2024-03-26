<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Http\Controllers\Helpers\Images;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\Delivery\DeliveryResources;
use App\Http\Resources\Payments\PaymentsResources;
use App\Jobs\StorageIRL;
use App\Jobs\TelegramOrder;
use App\Models\Payment;
use App\Models\Postcards;
use App\Models\Product;
use App\Models\Shipping;
use App\Services\Order\OrderService;
use App\Services\Order\TimeSlots;
use App\Services\Payment\PaymentHandler;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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
        $slots = new TimeSlots();
        return response()->json(
            $slots->slotTimes($request->input('date'))
        );
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
