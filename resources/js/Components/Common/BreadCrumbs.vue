<template>
    <ul class="breadcrumbs">
        <li class="breadcrumbs-item">
            <Link :href="route('index')">Главная</Link>
        </li>
        <template v-if="this.child">
            <li class="breadcrumbs-item"
                v-for="item in this.child"
                :key="item.title"
            >
                <Link v-if="item.props"
                    :href="route(item.link, item.props)">{{ item.title  }}</Link>
                <Link v-else
                    :href="route(item.link)">{{ item.title  }}</Link>
            </li>
        </template>
    </ul>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    child: {
        type: Array,
        default: null,
    }
})
</script>
