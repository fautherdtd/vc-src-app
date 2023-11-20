<template>
    <div class="footer-mobile">
        <div class="footer-mobile_nav">
            <div class="footer-mobile_nav--category">
                <Link class="header-menu_nav--link-mob"
                      v-for="category in $page.props.share.categories.data"
                        :href="route('catalog', category.slug)">
                    {{ category.name }}
                </Link>
            </div>
            <div class="footer-mobile_nav--pages">
                <Link :href="route('catalog')"
                      class="header-menu_nav--link-mob">
                    <span>Каталог</span>
                </Link>
                <Link :href="route('delivery')"
                      class="header-menu_nav--link-mob">
                    <span>Доставка</span>
                </Link>
                <Link :href="route('payment')"
                      class="header-menu_nav--link-mob">
                    <span>Оплата</span>
                </Link>
                <Link :href="route('about')"
                      class="header-menu_nav--link-mob">
                    <span>О нас</span>
                </Link>
            </div>
        </div>
    </div>
    <div class="footer-mobile_bottom">
        <p>
            <a class="footer-mobile_bottom--phone" href="tel: 8 (928) 045 66 17">8 (928) 045 66 17</a>
        </p>
        <p>
            <a href="https://yandex.ru/profile/-/CDeQv0IX" target="_blank">г. Дербент, ул. Кобякова, 3/5 <br>Ежедневно 08:00 - 00:00</a>
        </p>
        <div class="footer-container_address--item">
            <p>Доставка цветов по Дербенту.</p>
            <p>Все права защищены © 2023 Вальс-цветов.</p>
        </div>
    </div>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";
</script>
