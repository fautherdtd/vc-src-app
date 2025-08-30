<template>
    <header class="header-mobile">
        <div class="header-mobile_menu">
            <div class="header-mobile_menu--burger">
                <input type="checkbox" />
                <span></span>
                <span></span>
                <span></span>
                <div class="menu-mobile">
                    <div class="header-menu_nav--link-mob--drop"
                         @click="activeMobMenu = !activeMobMenu">
                        Каталог
                        <ion-icon name="chevron-down-outline" v-if="!activeMobMenu"></ion-icon>
                        <ion-icon name="chevron-up-outline" v-else></ion-icon>
                    </div>
                    <div  class="header-menu_nav--link-mob--drop_content"
                        v-if="activeMobMenu">
                        <p v-for="category in $page.props.share.categories.data">
                            <Link :href="route('catalog', category.slug)"
                                  class="header-menu_nav--link-mob">
                                - {{ category.name }}
                            </Link>
                        </p>
                    </div>
                    <Link :href="route('delivery')"
                          class="header-menu_nav--link-mob">
                        Доставка
                    </Link>
                    <Link :href="route('payment')"
                          class="header-menu_nav--link-mob">
                        Оплата
                    </Link>
                    <Link :href="route('about')"
                          class="header-menu_nav--link-mob">
                        О нас
                    </Link>
                </div>
            </div>
        </div>
        <div class="header-mobile_logo">
            <Link :href="route('index')">
                <img src="https://valscvetov.ru/logo_min.svg" width="85" height="85" alt="">
            </Link>
        </div>
        <div class="header-mobile_btn">
            <div class="header-menu_btn--item">
                <Link :href="route('favorites.index')">
                    <ion-icon name="heart-outline" size="large"></ion-icon>
                    <span class="icon-badge">{{ $page.props.share.favorites.totalQuantity }}</span>
                </Link>
            </div>
            <div class="header-menu_btn--item">
                <Link :href="route('cart.index')">
                    <ion-icon name="cart-outline" size="large"></ion-icon>
                    <span class="icon-badge">{{ $page.props.share.cart.totalQuantity }}</span>
                </Link>
            </div>
        </div>
    </header>
</template>
<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
const activeMobMenu = ref(false)
</script>
