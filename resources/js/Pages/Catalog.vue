<template>
    <AppLayout title="Каталог">
        <BreadCrumbs :child="[
            {id: 1, title: 'Каталог', link: 'catalog'},
        ]"/>
        <div class="container">
            <div class="catalog-page">
                <ul class="catalog-nav">
                    <li class="catalog-nav_item"
                        :class="route().current('catalog', category.slug) ? 'catalog-nav_item--active' : ''"
                        v-for="category in $page.props.share.categories.data" :key="category.id">
                        <Link :href="route('catalog', category.slug)">
                            {{ category.name }} <span style="font-size: 14px" v-if="category.is_deactivation">(недоступно)</span>
                        </Link>
                    </li>
                </ul>
                <div class="catalog-product">
                    <div class="catalog-product_sort">
                        <dropdown-catalog/>
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
                        <template v-if="!visiblePostcard">
                            <ProductCart
                                v-for="product in products.data"
                                :product="product"
                                :key="product.id"/>
                        </template>
                        <template v-else>
                            <PostcardCart
                                v-for="postcard in products.data"
                                :postcard="postcard"
                                :key="postcard.id"
                            />
                        </template>
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
import DropdownCatalog from "@/Components/Inputs/DropdownCatalog.vue";
import PostcardCart from "@/Components/Products/PostcardCart.vue";
import BreadCrumbs from "@/Components/Common/BreadCrumbs.vue";

defineProps({
    products: Object,
    visiblePostcard: Boolean
})
const sortByEnabled = ref('id');
const active = ref(false);
const changeSort = (sort) => {
    sortByEnabled.value = sort;
    router.get(usePage().url,{
        sort: sort
    })
}
</script>
