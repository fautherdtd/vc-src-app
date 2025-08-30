<template>
    <header class="header-menu">
        <div class="header-menu_logo">
            <Link :href="route('index')">
                <img src="https://valscvetov.ru/logo.svg" width="198" height="97" alt="">
            </Link>
        </div>
        <div class="header-menu_nav">
            <Link :href="route('catalog')">
                <a href="" class="header-menu_nav--link"
                   :class="route().current('catalog')  ? 'header-menu_nav--link-active' : ''"
                    >Каталог</a>
            </Link>
            <Link :href="route('delivery')">
                <a href=""
                   class="header-menu_nav--link"
                   :class="route().current('delivery') ? 'header-menu_nav--link-active' : ''"
                    >Доставка</a>
            </Link>
            <Link :href="route('payment')">
                <a href=""
                   :class="route().current('payment') ? 'header-menu_nav--link-active' : ''"
                   class="header-menu_nav--link">Оплата</a>
            </Link>
            <Link :href="route('about')">
                <a href=""
                   :class="route().current('about') ? 'header-menu_nav--link-active' : ''"
                   class="header-menu_nav--link">О нас</a>
            </Link>
        </div>
        <div class="header-menu_btn">
            <div class="header-menu_btn--item">
                <Link :href="route('favorites.index')">
                    <ion-icon name="heart-outline" size="large"></ion-icon>
                    <span class="icon-badge">{{ $page.props.share.favorites.totalQuantity }}</span>
                </Link>
            </div>
            <div class="header-menu_btn--item">
                <Link :href="route('cart.index')">
                    <ion-icon name="cart-outline" size="large"></ion-icon>
                    <span class="icon-badge">{{ $page.props.share.cart.totalQuantity }}</span>
                </Link>
            </div>
        </div>
    </header>
    <HeaderMobile/>
</template>
<script setup>
import { Link, router } from '@inertiajs/vue3';
import HeaderMobile from "@/Components/Common/HeaderMobile.vue";
defineProps({
    title: String,
});
</script>
