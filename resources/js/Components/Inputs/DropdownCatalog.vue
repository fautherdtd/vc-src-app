<template>
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
               v-for="category in $page.props.share.categories.data" :key="category.id">
                <Link :href="route('catalog', category.slug)">{{ category.name }}</Link>
            </p>
        </div>
    </div>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";
import {ref} from "vue";
const active = ref(false)
</script>
