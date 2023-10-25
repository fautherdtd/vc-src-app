<template>
    <AppLayout title="Доставка">
        <BreadCrumbs  :child="[
            {id: 1, title: 'Оплата', link: 'payment'},
        ]"/>
        <h1 class="page-title">ОПЛАТА</h1>
        <div class="page-container">
            <p>Заказ осуществляется только после полной предоплаты.</p>

            <p class="page-container_header-sub">Способы оплаты:</p>
            <ul class="page-container_list">
                <li>Банковской картой (МИР, MasterCard, VISA, Maestro, UnionPay)</li>
                <li>SberPay или Альфа-клик</li>
                <li>Электронными деньгами QIWI</li>
                <li>Наличными при самовывозе</li>
                <li>Переводом на расчётный счёт (для этого свяжитесь предварительно с менеджером)</li>
            </ul>

            <p class="page-container_header-sub">Оплата из-за рубежа или другим способом:</p>
            <p>Выберите способ "Иной способ оплаты" при оформлении заказа, а также напишите в комментариях к заказу о желаемом способе оплаты.</p>
            <p>Наш менеджер свяжется с вами и обсудит желаемый способ оплаты.</p>
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadCrumbs from "@/Components/Common/BreadCrumbs.vue";
</script>
