<template>
    <div class="product-item">
        <div class="product-item_img" :style="'background-image: url(' + product.image + ')'" ></div>
        <Link :href="route('product', product.slug)">
            <div class="product-item_content">
                <h5 class="product-item_content--title">{{  product.name  }}</h5>
                <p class="product-item_content--compound">Состав: {{  product.compound  }}</p>
            </div>
        </Link>
        <div class="product-item_footer">
            <div class="product-item_footer--price">{{  product.price  }} ₽</div>
            <div class="product-item_footer--btn" @click="addToCart(product.id, {
                    price: product.price,
                    count: 1
                })">
                В корзину
                <ion-icon name="cart-outline" size="small"></ion-icon>
            </div>
        </div>
    </div>
</template>
<script setup>
import {router, Link} from "@inertiajs/vue3";
import addToCart from "@/Mixins/Cart.js";

defineProps({
    product: Object
})
</script>
