<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Информация для флориста</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>


<div class="p-10">
    <div>
        <div class="px-4 sm:px-0">
            <h3 class="text-2xl font-semibold leading-7 text-gray-900 mb-10">Заказ #{{ $order->number }}</h3>
            <a href="{{route('docs.courier', $order->id)}}" class="p-2 border bg-amber-100 mt-5">Распечатать информацию для курьера</a>
        </div>
        <div class="mt-6 pb-2">
            <p class="text-2xl border-b mb-2">Информация по заказу</p>
            <p><span class="font-bold">Доставить нужно: </span> {{ $order->delivery_time->format('d.m H:i') }}</p>
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
            <p class="text-2xl border-b mb-2">Клиент и получатель</p>
            <p><span class="font-bold">Клиент: </span> {{ $order->customer->name }}, {{ $order->customer->phone }}</p>
            @if(!is_null($order->recipient['name']))
                <p><span class="font-bold">Получатель: </span> {{ $order->recipient['name'] }}, {{ $order->recipient['phone'] }}</p>
            @endif
            <p>
                <span class="font-bold">Анонимный заказ: </span>
                @if($order->anonymous)
                    <span class="text-green-700">● Да</span>
                @else
                    <span class="text-red-700">● Нет</span>
                @endif
            </p>
        </div>
        <div class="mt-6">
            <p class="text-2xl border-b mb-2">Товары к сбору</p>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <table class="min-w-full text-left text-sm font-light">
                                <thead class="border-b font-medium dark:border-neutral-500">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Наименование</th>
                                    <th scope="col" class="px-6 py-4">Модификации</th>
                                    <th scope="col" class="px-6 py-4">Кол-во букетов</th>
                                    <th scope="col" class="px-6 py-4">Изображение</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $item)
                                    <tr class="border-b dark:border-neutral-500">
                                        <td class="whitespace-nowrap px-6 py-4">{{ $item->{strtolower($item->type)}->name }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            @if(!is_null($item->product->modify))
                                                @foreach($item->product->modify as $key => $value)
                                                    @if($value['Цена'] == intval($item->unit_price))
                                                        Общее кол-во цветов: {{ $value['Кол-во цветов'] }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $item->qty }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <a target="_blank" href="{{ Storage::disk('public')->url($item->{strtolower($item->type)}->attachment->first()->path . $item->{strtolower($item->type)}->attachment->first()->name . '.' . $item->{strtolower($item->type)}->attachment->first()->extension) }}">
                                                <img
                                                    width="150"
                                                    height="150"
                                                    src="{{ Storage::disk('public')->url($item->{strtolower($item->type)}->attachment->first()->path . $item->{strtolower($item->type)}->attachment->first()->name . '.' . $item->{strtolower($item->type)}->attachment->first()->extension) }}" alt="">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


</body>
</html>
