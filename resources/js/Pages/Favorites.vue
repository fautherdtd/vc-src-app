<template>
    <AppLayout title="Избранные">
        <BreadCrumbs :child="[{id: 1, title: 'Избранное', link: 'favorites.index'}]"/>
        <h1 class="page-title">ИЗБРАННОЕ</h1>
        <div class="page-container" v-if="$page.props.share.favorites.totalQuantity === 0">
            Вы пока ничего не добавили в избранное.
            <Link :href="route('catalog')" style="color: #000; border-bottom: 1px dashed">Вернуться в в каталог.</Link>
        </div>
        <template v-else>
            <h3 class="page-title-sub">Композиции</h3>
            <div class="product-favorites">
                <ProductCart
                    v-for="product in products.data"
                    :key="product.id"
                    :product="product"/>
            </div>
            <h3 class="page-title-sub">Открытки</h3>
            <div class="product-favorites">
                <PostcardCart
                    v-for="postcard in postcards.data"
                    :key="postcard.id"
                    :postcard="postcard"/>
            </div>
        </template>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCart from "@/Components/Products/ProductCart.vue";
import BreadCrumbs from "@/Components/Common/BreadCrumbs.vue";
import {Link, router} from "@inertiajs/vue3";
import PostcardCart from "@/Components/Products/PostcardCart.vue";
const props = defineProps({
    postcards: Object,
    products: Object,
})
</script>
