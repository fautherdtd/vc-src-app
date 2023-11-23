<template>
    <div
        class="product-item"
        :class="product.is_deactivation === true ? 'product-item_deactivate' : ''"
    >
        <div class="product-item_img" :style="'background-image: url(' + product.image + ')'" ></div>
        <Link :href="route('product', product.slug)">
            <div class="product-item_content">
                <h5 class="product-item_content--title">{{  product.name  }}</h5>
                <p class="product-item_content--compound">Состав: {{  product.compound  }}</p>
            </div>
        </Link>
        <div class="product-item_footer">
            <div class="product-item_footer--price">{{  product.price  }} ₽</div>
            <div class="product-item_footer--btn">
                <div class="product-item_footer--btn--item"
                     @click="addToFavorite(product.id, 'products')">
                    <span class="product-item_footer--btn--item_label">В избранное</span>
                    <template
                        v-if="$page.props.share.favorites.content.hasOwnProperty(product.id)">
                        <ion-icon name="heart-dislike-outline"></ion-icon>
                    </template>
                    <template v-else>
                        <ion-icon name="heart-outline"></ion-icon>
                    </template>
                </div>
                <template v-if="product.is_active === true">
                    <div class="product-item_footer--btn--item" @click="addToCart(product.id, {
                    price: product.price,
                    count: 1,
                    type: 'product'
                })">
                        В корзину
                        <ion-icon name="cart-outline" size="small"></ion-icon>
                    </div>
                </template>
                <template v-else>
                    Нет в наличии
                </template>
            </div>

        </div>
    </div>
</template>
<script setup>
import {router, Link} from "@inertiajs/vue3";
import addToCart from "@/Mixins/Cart.js";
import addToFavorite from "@/Mixins/Favorites.js";

defineProps({
    product: Object
})
</script>
