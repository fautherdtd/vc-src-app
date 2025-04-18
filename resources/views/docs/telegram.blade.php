<b>Заказ #{{ $order->number }}</b>

<b>Дата и время:</b> {{ $date }} время {{ $slot }}
<b>Текст:</b> {{ $order->notes }}

<b>Способ доставки:</b> {{ $order->shipping->label }}
@if($order->shipping_method != 'self')
<b>Адрес:</b> {{ $order->address }}
@if(!empty($order->address_sub))
{{$order->address_sub['entrance']}}, этаж: {{$order->address_sub['floor']}}, квартира: {{$order->address_sub['apartment']}}, домофон: {{$order->address_sub['intercom']}}
@endif
@endif

<b>Заказчик:</b> {{ $order->customer->name }}, {{ $order->customer->phone }}
@if(!is_null($order->recipient['name']))
<b>Получатель:</b> {{ $order->recipient['name'] }}, {{ $order->recipient['phone'] }}
@endif
<b>Анонимный заказ:</b> {{ $order->anonymous ? "● Да" : "● Нет"}}
@foreach($order->items as $key => $item)
<b>Продукция:</b>
- {{ $item->{strtolower($item->type)}->name }}
    @if(!is_null($item->product->modify))
        @foreach($item->product->modify as $key => $value)
            @if($value['Цена'] == intval($item->unit_price))
                (общее кол-во цветов в букете {{ $value['Кол-во цветов'] }} )
            @endif
        @endforeach
    @endif
@endforeach
