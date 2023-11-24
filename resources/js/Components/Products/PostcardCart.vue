<template>
    <div class="product-item">
        <div class="product-item_carousel">
            <Carousel :itemsToShow="1" :wrap-around="true" :transition="500">
                <Slide v-for="(image, id) in postcard.images" :key="image">
                    <div class="product-item_img"
                         @click="() => showImg(id)"
                         :style="'background-image: url(' + image + ')'" ></div>
                </Slide>
            </Carousel>
            <vue-easy-lightbox :visible="visibleRef"
                               :imgs="postcard.images"
                               :index="indexRef"
                               :zoomDisabled="false"
                               :moveDisabled="true"
                               :rotateDisabled="true"
                               :pinchDisabled="true"
                               :maskClosable="true"
                               @hide="onHide">
            </vue-easy-lightbox>
        </div>
        <div class="product-item_content">
            <h5 class="product-item_content--title">{{  postcard.name  }}</h5>
            <p class="product-item_content--compound">{{  postcard.description  }}</p>
        </div>
        <div class="product-item_footer">
            <div class="product-item_footer--price">{{  postcard.price  }} ₽</div>
            <div class="product-item_footer--btn">
                <div class="product-item_footer--btn--item" @click="addToFavorite(postcard.id, 'postcards')">
                    <span class="product-item_footer--btn--item_label">В избранное</span>
                    <template
                        v-if="$page.props.share.favorites.content.hasOwnProperty(postcard.id)">
                        <ion-icon name="heart-dislike-outline"></ion-icon>
                    </template>
                    <template v-else>
                        <ion-icon name="heart-outline"></ion-icon>
                    </template>
                </div>
                <div class="product-item_footer--btn--item" @click="addToCart(postcard.id, {
                    type: 'postcard',
                    price: postcard.price,
                    count: 1
                })">
                    В корзину
                    <ion-icon name="cart-outline" size="small"></ion-icon>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import addToCart from "@/Mixins/Cart.js";
import {Carousel, Slide} from "vue3-carousel";
import 'vue3-carousel/dist/carousel.css'
import addToFavorite from "@/Mixins/Favorites.js";
import VueEasyLightbox from 'vue-easy-lightbox'
import {ref} from "vue";

defineProps({
    postcard: Object
})
const visibleRef = ref(false)
const indexRef = ref(0)
const showImg = (index) => {
    indexRef.value = index
    visibleRef.value = true
}
const onHide = () => visibleRef.value = false
</script>
