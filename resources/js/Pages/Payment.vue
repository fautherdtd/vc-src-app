<template>
    <AppLayout :title="data.seo_title"
               :description="data.seo_description">
        <BreadCrumbs  :child="[
            {id: 1, title: 'Оплата', link: 'payment'},
        ]"/>
        <h1 class="page-title">ОПЛАТА</h1>
        <div class="page-container" v-html="data.body">
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadCrumbs from "@/Components/Common/BreadCrumbs.vue";
defineProps({
    data: Object
})
</script>
<style>
.page-container h2 {
    font-size: 18px !important;
    font-weight: bold !important;
}
.page-container ul > li:before {
    content: '- ';
}
</style>
