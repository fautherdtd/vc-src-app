<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import Header from "@/Components/Common/Header.vue";
import Footer from "@/Components/Common/Footer.vue";

defineProps({
    title: String,
});
</script>

<template>
    <Head :title="title" />
    <div class="wrapper">
        <Header/>
        <main>
            <slot />
        </main>
    </div>
    <Footer/>
</template>
