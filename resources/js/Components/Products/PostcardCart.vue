<template>
    <div class="product-item">
        <div class="product-item_carousel">
            <Carousel :itemsToShow="1" :wrap-around="true" :transition="500">
                <Slide v-for="image in postcard.image" :key="image">
                    <div class="product-item_img" :style="'background-image: url(' + image + ')'" ></div>
                </Slide>
            </Carousel>
        </div>
        <div class="product-item_content">
            <h5 class="product-item_content--title">{{  postcard.name  }}</h5>
            <p class="product-item_content--compound">{{  postcard.description  }}</p>
        </div>
        <div class="product-item_footer">
            <div class="product-item_footer--price">{{  postcard.price  }} ₽</div>
            <div class="product-item_footer--btn" @click="addToCart(postcard.id, {
                    type: 'postcard',
                    price: postcard.price,
                    count: 1
                })">
                В корзину
                <ion-icon name="cart-outline" size="small"></ion-icon>
            </div>
        </div>
    </div>
</template>
<script setup>
import addToCart from "@/Mixins/Cart.js";
import {Carousel, Slide} from "vue3-carousel";
import 'vue3-carousel/dist/carousel.css'

defineProps({
    postcard: Object
})
</script>
