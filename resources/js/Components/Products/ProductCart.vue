<template>
    <div class="product-item">
        <div class="product-item_img" :style="'background-image: url(' + product.image + ')'" ></div>
        <Link :href="route('product', product.slug)">
            <div class="product-item_content">
                <h5 class="product-item_content--title">{{  product.name  }}</h5>
                <p class="product-item_content--compound">Состав: {{  product.compound  }}</p>
            </div>
        </Link>
        <div class="product-item_footer">
            <div class="product-item_footer--price">{{  product.price  }} ₽</div>
            <div class="product-item_footer--btn">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" :width="36" :height="36" fill="none">
                        <path d="M33.25 14.8333V13.6667C33.25 13.1144 32.8023 12.6667 32.25 12.6667H5.75C5.19772 12.6667 4.75 13.1144 4.75 13.6667V14.8333C4.75 15.3856 5.19772 15.8333 5.75 15.8333H7.13589C7.59476 15.8333 7.99474 16.1456 8.10603 16.5908L10.7046 26.9851C10.9272 27.8754 11.7272 28.5 12.6449 28.5H25.3551C26.2729 28.5 27.0728 27.8754 27.2954 26.9851L29.894 16.5908C30.0053 16.1456 30.4052 15.8333 30.8641 15.8333H32.25C32.8023 15.8333 33.25 15.3856 33.25 14.8333Z" stroke="#222222" stroke-width="1.4"/>
                        <path d="M13.4583 5.54166L10.2917 10.2917M24.5416 5.54166L27.7083 10.2917" stroke="#222222" stroke-linecap="round"/>
                        <path d="M16.625 22.9583L15.0417 18.2083M21.375 22.9583L22.9583 18.2083" stroke="#222222" stroke-linecap="round"/>
                    </svg>
                </span>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="36" viewBox="0 0 35 35" fill="none">
                        <path d="M6.49057 20.2828L16.8153 29.9818C17.1398 30.2866 17.302 30.439 17.5 30.439C17.698 30.439 17.8602 30.2866 18.1847 29.9818L28.5094 20.2828C31.3622 17.603 31.7086 13.193 29.3093 10.1005L28.8582 9.51905C25.9879 5.8196 20.2266 6.44003 18.2097 10.6658C17.9248 11.2627 17.0752 11.2627 16.7903 10.6657C14.7735 6.44003 9.0121 5.81961 6.14185 9.51905L5.6907 10.1005C3.29139 13.193 3.63782 17.6029 6.49057 20.2828Z" fill-opacity="0.25" stroke="#222222" stroke-width="1.4"/>
                    </svg>
                </span>
            </div>
        </div>
    </div>
</template>
<script setup>
import {router, Link} from "@inertiajs/vue3";

defineProps({
    product: Object
})
</script>
