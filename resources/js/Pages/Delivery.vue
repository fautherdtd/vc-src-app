<template>
    <AppLayout
        :title="data.seo_title"
        :description="data.seo_description">
        <BreadCrumbs  :child="[
            {id: 1, title: 'Доставка', link: 'delivery'},
        ]"/>
        <h1 class="page-title">ДОСТАВКА</h1>
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
</style>
