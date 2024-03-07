<b>Заказ #{{ $order->number }}</b>
____________________________
<b>Информация по заказу:</b>

Подготовить нужно: {{ $date }} время {{ $slot }}
Комментарий или текст к открытке: {{ $order->notes }}

____________________________
<b>Доставка:</b>
Способ доставки: {{ $order->shipping->label }}
@if($order->shipping_method != 'self')
Адрес Доставки: {{ $order->address }}
@if(!empty($order->address_sub))
Информация по адресу: Подъезд: {{$order->address_sub['entrance']}}, этаж: {{$order->address_sub['floor']}}, квартира: {{$order->address_sub['apartment']}}, домофон: {{$order->address_sub['intercom']}}
@endif
@endif

____________________________
<b>Заказчик и получатель:</b>
Заказчик: {{ $order->customer->name }}, {{ $order->customer->phone }}
@if(!is_null($order->recipient['name']))
Получатель: {{ $order->recipient['name'] }}, {{ $order->recipient['phone'] }}
@endif
Анонимный заказ: {{ $order->anonymous ? "● Да" : "● Нет"}}

____________________________
<b>Товары к сбору:</b>

@foreach($order->items as $key => $item)
Позиция: #{{ $key + 1 }}
Наименование: {{ $item->{strtolower($item->type)}->name }}
@if(!is_null($item->product->modify))
@foreach($item->product->modify as $key => $value)
@if($value['Цена'] == intval($item->unit_price))
Дополнительно: общее кол-во цветов в букете {{ $value['Кол-во цветов'] }}
@endif
@endforeach
@endif
Кол-во позиций: {{ $item->qty }}
@endforeach
