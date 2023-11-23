<template>
    <AppLayout
        :title="product.data.seo_title"
        :description="product.data.seo_description"
    >
        <div class="product-detail">
            <div class="product-detail_carousel">
                <Carousel v-bind="settings">
                    <Slide v-for="(item, id) in product.data.gallery" :key="item">
                        <div class="product-detail_carousel--main"
                             @click="() => showImg(id)"
                             :style="'background-image: url(' + item + ')'"></div>
                    </Slide>
                </Carousel>
                <vue-easy-lightbox :visible="visibleRef"
                                   :imgs="product.data.gallery"
                                   :index="indexRef"
                                   :zoomDisabled="false"
                                   :moveDisabled="true"
                                   :rotateDisabled="true"
                                   :pinchDisabled="true"
                                   :maskClosable="true"
                                   @hide="onHide">
                </vue-easy-lightbox>

            </div>
            <div class="product-detail_info">
                <div class="product-detail_info--title">
                    <div class="product-detail_info--title-sub">
                        <span>{{ product.data.category.name }}</span>
                        <h1>{{ product.data.name }}</h1>
                    </div>
                    <button class="btn-favorite"
                        @click="addToFavorite(product.data.id, 'products')">
                        <template
                            v-if="$page.props.share.favorites.content.hasOwnProperty(product.data.id)">
                            <ion-icon name="heart-dislike-outline" size="large"></ion-icon>
                        </template>
                        <template v-else>
                            <ion-icon name="heart-outline" size="large"></ion-icon>
                        </template>
                    </button>
                </div>
                <fieldset class="product-detail_info--chars">
                    <legend>Детали</legend>
                    <p class="product-detail_info--chars-item" v-for="(value, key) in product.data.chars" :key="key">
                        <b>{{  value['Название'] }}: </b> {{  value['Значение'] }}
                    </p>
                    <p class="product-detail_info--chars-item"><b>Состав: </b> {{ product.data.compound }}</p>
                </fieldset>
                <div class="product-detail_info--description">{{ product.data.description }}</div>
                <div class="product-detail_info--flower-count" v-if="product.data.modify">
                    <label for="flower-count" class="input-block">
                        <h4>Кол-во цветов: </h4>
                        <select name="flower-count"
                                v-model="options.modifyPrice"
                                id="flower-count"
                                class="select-primary">
                            <option value="0" selected>Сбросить модификацию</option>
                            <option
                                :value="modify['Цена']" v-for="modify in product.data.modify">
                                {{ modify['Кол-во цветов'] }} - {{ modify['Цена'] }} руб.
                            </option>
                        </select>
                    </label>
                </div>
                <div class="product-detail_info--footer">
                    <h1 class="product-detail_info--footer-price">
                        {{ options.price }} ₽
                    </h1>
                    <div class="product-detail_info--footer-count">
                        <div class="input-count">
                            <button @click="options.countItem === 1 ? options.countItem = 1 : options.countItem--">-</button>
                            <input type="number" :value="options.countItem" maxlength="99">
                            <button @click="options.countItem++">+</button>
                        </div>
                    </div>
                    <template v-if="product.data.category.is_deactivation === true">
                        <p style="text-align: center">
                            Сейчас недоступно
                        </p>
                    </template>
                    <template v-else-if="product.data.is_active">
                        <button
                            v-if="! $page.props.share.cart.content.hasOwnProperty(product.data.id)"
                            @click="addToCart(product.data.id, {
                              count: options.countItem,
                              price: options.price / options.countItem,
                              type: 'product'
                            })" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="34" viewBox="0 0 30 34" fill="none">
                                <path
                                    d="M26.25 12.9003V12.1203C26.25 11.568 25.8023 11.1203 25.25 11.1203H4.75C4.19772 11.1203 3.75 11.568 3.75 12.1203V12.9003C3.75 13.4526 4.19772 13.9003 4.75 13.9003H5.44986C5.91763 13.9003 6.3229 14.2246 6.4255 14.681L8.39899 23.4593C8.6042 24.372 9.41474 25.0206 10.3503 25.0206H19.6497C20.5853 25.0206 21.3958 24.372 21.601 23.4593L23.5745 14.681C23.6771 14.2246 24.0824 13.9003 24.5501 13.9003H25.25C25.8023 13.9003 26.25 13.4526 26.25 12.9003Z"
                                    fill="white" stroke="#000" stroke-width="1.4" />
                                <path d="M10.625 4.86511L8.125 9.03521M19.375 4.86511L21.875 9.03521" stroke="#fff"
                                      stroke-linecap="round" />
                                <path d="M13.125 20.1555L11.875 15.9854M16.875 20.1555L18.125 15.9854" stroke="#fff"
                                      stroke-linecap="round" />
                            </svg>
                            в корзину
                        </button>
                        <button class="btn btn-transparent"  v-else>
                            В корзине
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M5 14L8.23309 16.4248C8.66178 16.7463 9.26772 16.6728 9.60705 16.2581L18 6" stroke="#222222" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </template>
                    <template v-else>
                        Нет в наличии
                    </template>
                </div>
            </div>
        </div>
        <h1 class="header-title">Вам может понравиться</h1>
        <div class="product-recommended">
          <ProductCart
              v-for="product in popular.data"
              :key="product.id"
              :product="product"/>
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCart from "@/Components/Products/ProductCart.vue";
import {ref, watch} from "vue";
import {useForm, usePage, Link} from "@inertiajs/vue3";
import addToCart from "@/Mixins/Cart.js";
import addToFavorite from "@/Mixins/Favorites.js";
import {Carousel, Slide} from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import VueEasyLightbox from 'vue-easy-lightbox'

const props = defineProps({
    product: Object,
    popular: Object
})
const options = useForm({
    price: usePage().props.product.data.price,
    countItem: ref(1),
    modifyPrice: ref(0)
})
watch(() => options.countItem, (current, prev) => {
    let currentPrice = options.modifyPrice ==  0 ? usePage().props.product.data.price : options.modifyPrice;
    current > prev ?
        options.price = currentPrice * current : options.price -= currentPrice
})

watch(() => options.modifyPrice, (current) => {
    if (current == 0) {
        options.price = usePage().props.product.data.price * options.countItem
    } else {
        options.price = Number(current) * options.countItem
    }
})

const settings = {
    itemsToShow: 1.2,
    snapAlign: 'center',
    wrapAround: true
}
const visibleRef = ref(false)
const indexRef = ref(0)
const showImg = (index) => {
    indexRef.value = index
    visibleRef.value = true
}
const onHide = () => visibleRef.value = false

</script>
