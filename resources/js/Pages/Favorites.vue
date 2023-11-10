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
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCart from "@/Components/Products/ProductCart.vue";
import BreadCrumbs from "@/Components/Common/BreadCrumbs.vue";

const props = defineProps({
    favorites: Object
})
</script>
