<template>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-container_logo">
                <img src="https://valscvetov.ru/logo.svg" width="198" height="97" alt="">
            </div>
            <ul class="footer-container_nav">
                <li>
                    <Link :href="route('catalog')">Каталог</Link>
                </li>
                <li>
                    <Link :href="route('delivery')">Доставка</Link>
                </li>
                <li>
                    <Link :href="route('payment')">Оплата</Link>
                </li>
                <li>
                    <Link :href="route('about')">О нас</Link>
                </li>
            </ul>
            <div class="footer-container_contact">
                <p class="footer-container_contact--social">
                    <a href="https://www.instagram.com/vals.cvetov/" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.17157 4.17157C3 5.34315 3 7.22876 3 11V13C3 16.7712 3 18.6569 4.17157 19.8284C5.34315 21 7.22876 21 11 21H13C16.7712 21 18.6569 21 19.8284 19.8284C21 18.6569 21 16.7712 21 13V11C21 7.22876 21 5.34315 19.8284 4.17157C18.6569 3 16.7712 3 13 3H11C7.22876 3 5.34315 3 4.17157 4.17157ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z" fill="#7E869E" fill-opacity="0.25"/>
                            <path d="M3 11C3 7.22876 3 5.34315 4.17157 4.17157C5.34315 3 7.22876 3 11 3H13C16.7712 3 18.6569 3 19.8284 4.17157C21 5.34315 21 7.22876 21 11V13C21 16.7712 21 18.6569 19.8284 19.8284C18.6569 21 16.7712 21 13 21H11C7.22876 21 5.34315 21 4.17157 19.8284C3 18.6569 3 16.7712 3 13V11Z" stroke="#222222" stroke-width="1.2"/>
                            <circle cx="16.5" cy="7.5" r="1.5" fill="#222222"/>
                            <circle cx="12" cy="12" r="3.4" stroke="#222222" stroke-width="1.2"/>
                        </svg>
                        vals.cvetov
                    </a>
                </p>
                <p class="mb-2"><a href="tel: 8 (928) 045 66 17">8 (928) 045 66 17</a></p>
                <iframe src="https://yandex.ru/sprav/widget/rating-badge/143295200969?type=award&theme=dark" width="150" height="50" frameborder="0"></iframe>
            </div>
            <div class="footer-container_address">
                <div class="footer-container_address--item">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M17.7071 13.7071L20.3552 16.3552C20.7113 16.7113 20.7113 17.2887 20.3552 17.6448C18.43 19.57 15.3821 19.7866 13.204 18.153L11.6286 16.9714C9.88504 15.6638 8.33622 14.115 7.02857 12.3714L5.84701 10.796C4.21341 8.61788 4.43001 5.56999 6.35523 3.64477C6.71133 3.28867 7.28867 3.28867 7.64477 3.64477L10.2929 6.29289C10.6834 6.68342 10.6834 7.31658 10.2929 7.70711L9.27175 8.72825C9.10946 8.89054 9.06923 9.13846 9.17187 9.34373C10.3585 11.7171 12.2829 13.6415 14.6563 14.8281C14.8615 14.9308 15.1095 14.8905 15.2717 14.7283L16.2929 13.7071C16.6834 13.3166 17.3166 13.3166 17.7071 13.7071Z" fill="#7E869E" fill-opacity="0.25" stroke="#222222" stroke-width="1.2"/>
                        </svg>
                        Ежедневно 08:00 - 00:00
                    </p>
                    <p>г. Дербент, ул. Кобякова, 3/5</p>
                </div>
                <div class="footer-container_address--item">
                    Все права защищены © 2023 Вальс-цветов.
                </div>
            </div>
        </div>
    </footer>
    <FooterMobile/>
</template>
<script setup>
import { Link, router } from '@inertiajs/vue3';
import FooterMobile from "@/Components/Common/FooterMobile.vue";
</script>
