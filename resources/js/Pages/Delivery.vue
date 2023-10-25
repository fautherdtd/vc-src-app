<template>
    <AppLayout title="Доставка">
        <BreadCrumbs  :child="[
            {id: 1, title: 'Доставка', link: 'delivery'},
        ]"/>
        <h1 class="page-title">ДОСТАВКА</h1>
        <div class="page-container">
            <p class="page-container_header-sub">Самовывоз:</p>
            <p>Вы можете забрать свой заказ по адресу:</p>
            Дербент, ул. Кобякова, д. 12 с 7:00 до 00:00.

            <p class="page-container_header-sub">Время доставки:</p>
            <p>Доставляем ежедневно с 7:00 до 00:00.</p>
            <p>Если нужна доставка в более ранее или более позднее время,
            свяжитесь с менеджером для оформления индивидуальных условий.</p>
            <p>Средний интервал доставки 1-2 часа.</p>

            <p class="page-container_header-sub">Стоимость доставки:</p>
            <p>От 250₽ в зависимости от дальности адреса. <br> Точная стоимость доставки рассчитывается автоматически при оформлении заказа.</p>
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadCrumbs from "@/Components/Common/BreadCrumbs.vue";
</script>
