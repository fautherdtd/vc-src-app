<template>
    <div class="dropdown catalog-nav_mob" @click="active = !active">
        <span>
            Каталог
            <ion-icon name="chevron-down-outline" v-if="!active"></ion-icon>
            <ion-icon name="chevron-up-outline" v-else></ion-icon>
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
