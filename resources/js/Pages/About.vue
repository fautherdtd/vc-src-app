<template>
    <AppLayout title="О Нас">
        <BreadCrumbs  :child="[
            {id: 1, title: 'О нас', link: 'about'},
        ]"/>
        <h1 class="page-title">О НАС</h1>
        <div class="page-container">
            ВАЛЬС ЦВЕТОВ
            <p>Это история о любви к цветам, ко всему прекрасному. Это желание нести эту красоту в массы,
                сделать ее доступной для каждого. Проект создавался с осознанием того, что стильный красивый букет не обязательно
                должен стоить дорого.</p>
        </div>
        <div class="page-container_gallery">
            <Carousel :breakpoints="breakpoints" :wrapAround="true" :transition="500">
                <Slide v-for="item in gallery" :key="item">
                    <div class="carousel__item"
                         :style="'background-image: url(' + item + ')'"></div>
                </Slide>
                <template #addons>
                    <Pagination />
                </template>
            </Carousel>
        </div>
        <div class="page-about_info">
            <div class="page-about_info--text">
                МЫ - КОМАНДА <span>ПРОФЕССИОНАЛЬНЫХ
                    ФЛОРИСТОВ</span>, КОТОРЫЕ УЖЕ БОЛЕЕ 35 ЛЕТ
                СОЗДАЮТ ЭКСКЛЮЗИВНЫЕ ЦВЕТОЧНЫЕ
                КОМПОЗИЦИИ ДЛЯ ВАС.
            </div>
            <div class="page-about_info--stat">
                <div class="page-about_info--stat-item">
                    <p>200 +</p>
                    <span>Видов цветов</span>
                </div>
                <div class="page-about_info--stat-item">
                    <p>15</p>
                    <span>Сотрудников</span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadCrumbs from "@/Components/Common/BreadCrumbs.vue";
import {Carousel, Pagination, Slide} from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

const gallery = [
]
const breakpoints = {
    414: {
        itemsToShow: 1,
        snapAlign: 'center',
    },
    640: {
        itemsToShow: 1.8,
        snapAlign: 'center',
    },
}
</script>
