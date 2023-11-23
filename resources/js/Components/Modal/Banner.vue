<template>
    <div class="modal-item" @click="closeBanner(data.id)">
        <a :href="data.link">
            <div class="banner-src"
                 :style="'background-image: url(' + data.src + ')'"></div>
        </a>
    </div>
</template>
<script>
import {usePage} from "@inertiajs/vue3";
export default {
    props: {
        data: Object,
    },
    methods: {
        closeBanner: (id) => document.cookie = "bannerID_" + id + "=0",
    }
}
</script>
<style scoped>
.modal-item {
    width: 600px;
    height: 400px;
    background-color: #fff;
}
.banner-src {
    width: 100%;
    height: 100%;
    background-size: cover;
}
@media (max-width: 425px) {
    .modal-item {
        width: 90%;
        height: 300px;
    }
}
</style>
