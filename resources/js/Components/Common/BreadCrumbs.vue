<template>
    <ul class="breadcrumbs">
        <li class="breadcrumbs-item">
            <Link :href="route('index')">Главная</Link>
        </li>
        <template v-if="child">
            <li class="breadcrumbs-item" v-for="item in child" :key="item.id">
                <Link :href="route(item.link)">{{ item.title  }}</Link>
            </li>
        </template>
    </ul>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    child: {
        type: Object,
        default: null,
    }
})
</script>
