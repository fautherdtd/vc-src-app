<template>
    <AppLayout title="Корзина">
        <BreadCrumbs :child="[{id: 1, title: 'Корзина', link: 'cart.index'}]"/>
        <div class="container">
            <div class="cart-page" v-if="$page.props.share.cart.totalQuantity > 0">
                <div class="cart-page_items">
                    <CartItem v-for="(product, key) in $page.props.share.cart.content"
                              :product="product"
                              :cartID="key"
                              />
                </div>
                <div class="cart-page_block">
                    <div class="order-form_block--child">
                        <h1 class="cart-page_block--header">ИНФОРМАЦИЯ О ЗАКАЗЕ</h1>
                        <div class="order-form_block--child--content">
                            <div class="order-form_block--child--table">
                                <div class="order-form_block--child--table_item">
                                    <h3>{{ $page.props.share.cart.totalQuantity }} товар(а) на сумму:</h3>
                                    <h3>{{ $page.props.share.cart.totalPrice }} ₽</h3>
                                </div>
                                <div class="order-form_block--child--table_item">
                                    <h3>доставка:</h3>
                                    <h3>0 ₽</h3>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="order-form_block--child--content">
                            <div class="order-form_block--child--table">
                                <div class="order-form_block--child--table_item">
                                    <h3>ИТОГО:</h3>
                                    <h3>{{ $page.props.share.cart.totalPrice }} ₽</h3>
                                </div>
                            </div>
                        </div>
                        <Link :href="route('cart.order')">
                            <button class="btn btn-primary">ПЕРЕЙТИ К ОФОРМЛЕНИЮ</button>
                        </Link>
                    </div>
                </div>
            </div>
            <div class="cart-page" v-else>
                <CartEmpty/>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import CartItem from "@/Components/Cart/CartItem.vue";
import CartEmpty from "@/Components/Cart/CartEmpty.vue";
import BreadCrumbs from "@/Components/Common/BreadCrumbs.vue";
</script>
