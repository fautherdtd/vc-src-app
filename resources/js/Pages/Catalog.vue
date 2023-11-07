<template>
    <AppLayout title="Каталог">
        <div class="container">
            <div class="catalog-page">
                <ul class="catalog-nav">
                    <li class="catalog-nav_item"
                        :class="route().current('catalog', category.slug) ? 'catalog-nav_item--active' : ''"
                        v-for="category in categories.data" :key="category.id">
                        <Link :href="route('catalog', category.slug)">{{ category.name }}</Link>
                    </li>
                </ul>
                <div class="catalog-product">
                    <div class="catalog-product_sort">
                        <div class="dropdown catalog-nav_mob" @click="active = !active">
                            <span>
                                Каталог
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                  <circle cx="12" cy="12" r="1" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                  <circle cx="6" cy="12" r="1" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                  <circle cx="18" cy="12" r="1" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <div class="dropdown-content" v-if="active">
                                <p class="catalog-nav_item--active"
                                    v-for="category in categories.data" :key="category.id">
                                    <Link :href="route('catalog', category.slug)">{{ category.name }}</Link>
                                </p>
                            </div>
                        </div>
                        <span>Сортировать:</span>
                        <span class></span>
                        <span class="catalog-product_sort--text"
                              :class="sortByEnabled === 'id' ? 'catalog-product_sort--active' : ''"
                              @click="changeSort('id')"
                        >По умолчанию</span>
                        <span class="catalog-product_sort--text"
                              :class="sortByEnabled === 'price' ? 'catalog-product_sort--active' : ''"
                              @click="changeSort('price')"
                        >По цене</span>
                    </div>
                    <div class="catalog-product_data">
                        <ProductCart
                            v-for="product in products.data"
                            :product="product"
                            :key="product.id"/>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import {ref} from "vue";
import ProductCart from "@/Components/Products/ProductCart.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import {Link, router, usePage} from "@inertiajs/vue3";

defineProps({
    categories: Array,
    products: Array
})
const sortByEnabled = ref('id')
const active = ref(false);
const changeSort = (sort) => {
    sortByEnabled.value = sort;
    router.get(usePage().url,{
        sort: sort
    })
}
</script>
