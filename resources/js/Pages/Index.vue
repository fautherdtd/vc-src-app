<template>
    <AppLayout title="Главная">
        <div class="main-container">
            <div class="main-container_text">
                <div class="main-container_text--title">
                    Подари <span>счастье</span>
                    <div class="main-container_text--title-sub">себе и <span>близким</span></div>
                </div>
            </div>
            <div class="main-container_slide">
                <div class="main-container_slide--item">
                    <div class="main-container_slide--item-text">
                        <router-link to="/catalog">
                            МОНОБУКЕТЫ
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M20 12L20.3536 11.6464L20.7071 12L20.3536 12.3536L20 12ZM5 12.5C4.72386 12.5 4.5 12.2761 4.5 12C4.5 11.7239 4.72386 11.5 5 11.5V12.5ZM14.3536 5.64645L20.3536 11.6464L19.6464 12.3536L13.6464 6.35355L14.3536 5.64645ZM20.3536 12.3536L14.3536 18.3536L13.6464 17.6464L19.6464 11.6464L20.3536 12.3536ZM20 12.5H5V11.5H20V12.5Z"
                                    fill="#222222" />
                            </svg>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="popular-items">
            <div class="popular-items_head">
                <div class="popular-items_head--title">
                    <h1>Популярные</h1>
                    <span>То, что выбирают чаще</span>
                </div>
                <router-link to="/catalog">
                    К каталогу
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M20 12L20.3536 11.6464L20.7071 12L20.3536 12.3536L20 12ZM5 12.5C4.72386 12.5 4.5 12.2761 4.5 12C4.5 11.7239 4.72386 11.5 5 11.5V12.5ZM14.3536 5.64645L20.3536 11.6464L19.6464 12.3536L13.6464 6.35355L14.3536 5.64645ZM20.3536 12.3536L14.3536 18.3536L13.6464 17.6464L19.6464 11.6464L20.3536 12.3536ZM20 12.5H5V11.5H20V12.5Z"
                            fill="#850634" />
                    </svg>
                </router-link>
            </div>
            <div class="popular-items_content">
                <ProductCart
                    v-for="product in popular.data"
                    :key="product.id"
                    :product="product"
                />
            </div>
        </div>
        <div class="instagram-posts">
            <div class="instagram-posts_header">
                <h1>Оставайся с нами</h1>
                <h4>@vals.cvetov</h4>
            </div>
            <div class="instagram-posts_content">
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import { router } from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCart from "@/Components/Products/ProductCart.vue";
defineProps({
    popular: Array
})
</script>
