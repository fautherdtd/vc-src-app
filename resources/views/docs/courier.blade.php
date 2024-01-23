<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Информация для курьера</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .noPrint{
                display:none;
            }
        }
    </style>
</head>
<body>
    <div class="p-10">
        <div>

            <button onclick="window.print();" class="noPrint p-3 bg-amber-200 mb-5 border">
                распечатать
            </button>
            <div class="px-4 sm:px-0">
                <h3 class="text-2xl font-semibold leading-7 text-gray-900">Заказ #{{ $order->number }}</h3>
            </div>
            <div class="mt-6 pb-2">
                <p class="text-2xl border-b mb-2">Информация по заказу</p>
                <p>
                    <span class="font-bold">Доставка: </span>
                    {{ $order->delivery_time->format('d.m') }}, в период с {{ $slot[0] }} до {{ $slot[1] }}
                </p>
                <p>
                    <span class="font-bold">Статус оплаты: </span>
                    @if($order->is_payment)
                        <span class="text-green-700">Оплачен</span>
                    @else
                        <span class="text-red-700">Не оплачен</span>
                    @endif
                </p>
                <p><span class="font-bold">Комментарий или текст к открытке: </span> {{ $order->notes }}</p>
            </div>
            <div class="mt-6 pb-2">
                <p class="text-2xl border-b mb-2">Доставка</p>
                <p><span class="font-bold">Способ доставки: </span> {{ $order->shipping->label }}</p>
                @if($order->shipping_method != 'self')
                    <p><span class="font-bold">Адрес Доставки: </span> {{ $order->address }}</p>
                    @if(!empty($order->address_sub))
                        <ul class="ml-10 list-disc">
                            <li>Подъезд: {{$order->address_sub['entrance']}}</li>
                            <li>Этаж: {{$order->address_sub['floor']}}</li>
                            <li>Квартира: {{$order->address_sub['apartment']}}</li>
                            <li>Домофон: {{$order->address_sub['intercom']}}</li>
                        </ul>
                    @endif
                @endif
            </div>
            <div class="mt-6 pb-2">
                <p class="text-2xl border-b mb-2">Получатель</p>
                @if(!is_null($order->recipient['name']))
                    <p><span class="font-bold">Имя: </span> {{ $order->recipient['name'] }}</p>
                    <p><span class="font-bold">Номер телефона: </span> {{ $order->recipient['phone'] }}</p>
                @else
                    <p><span class="font-bold">Имя: </span> {{ $order->customer->name }}</p>
                    <p><span class="font-bold">Номер телефона: </span> {{ $order->customer->phone }}</p>
                @endif
                <p>
                    <span class="font-bold">Анонимный заказ: </span>
                    @if($order->anonymous)
                        <span class="text-green-700">● Да</span>
                    @else
                        <span class="text-red-700">● Нет</span>
                        <p><span class="font-bold">Имя отправителя: </span><span>{{ $order->customer->name }}</span></p>
                    @endif
                </p>
            </div>
        </div>

    </div>
</body>
</html>
