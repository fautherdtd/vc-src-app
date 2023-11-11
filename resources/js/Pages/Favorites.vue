<template>
    <AppLayout title="Избранные">
        <BreadCrumbs :child="[{id: 1, title: 'Избранное', link: 'favorites.index'}]"/>
        <h1 class="page-title">ИЗБРАННОЕ</h1>
        <div class="product-favorites">
            <ProductCart
                v-for="product in favorites.data"
                :key="product.id"
                :product="product"/>
        </div>
        <div class="page-container" v-if="$page.props.share.favorites.totalQuantity === 0">
            Вы пока ничего не добавили в избранное.
            <Link :href="route('catalog')" style="color: #000; border-bottom: 1px dashed">Вернуться в в каталог.</Link>
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCart from "@/Components/Products/ProductCart.vue";
import BreadCrumbs from "@/Components/Common/BreadCrumbs.vue";
import {Link, router} from "@inertiajs/vue3";
const props = defineProps({
    favorites: Object
})
</script>
