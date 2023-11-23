<script setup>
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import Header from "@/Components/Common/Header.vue";
import Footer from "@/Components/Common/Footer.vue";
import {openModal, container} from "jenesius-vue-modal";
import BannerComponent from "@/Components/Modal/Banner.vue";

const getCookie = function (name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
}

if (usePage().props.share.banner !== null) {
    if (getCookie('bannerID_' + usePage().props.share.banner.data.id) === undefined) {
        setTimeout(async () =>  {
            const modal = await openModal(BannerComponent, {
                data: usePage().props.share.banner.data
            });
            modal.onclose = () => {
                document.cookie = "bannerID_" + usePage().props.share.banner.data.id + "=0"
                return true;
            }
        }, 1)
    }
}

defineProps({
    title: String,
});
</script>

<template>
    <Head>
        <title>{{ title }}</title>
        <meta name="description" :content="description ?? 'Доставка цветов в г. Дербент'">
    </Head>
    <container/>
    <div class="wrapper">
        <Header/>
        <main>
            <slot />
        </main>
    </div>
    <notifications position="bottom right"/>

    <Footer/>
</template>
