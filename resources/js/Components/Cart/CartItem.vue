<template>
    <div class="cart-item">
        <div class="cart-item_img" :style="'background-image: url(' + props.product.options.image + ')'"></div>
        <div class="cart-item_content">
            <div class="cart-item_header">
                <div class="cart-item_header--sub">
                    {{ props.product.options.category }}
                    <div class="cart-item_header--title">{{ props.product.name }}</div>
                </div>
                <div class="cart-item_header--action">
                    <button class="btn btn-transparent" @click="removeCartProduct(props.cartID)">
                        <span>Удалить</span>
                        <ion-icon name="trash-outline" size="large"></ion-icon>
                    </button>
                </div>
            </div>
            <hr/>
            <div class="cart-item_footer">
                <div class="product-detail_info--footer-count">
                    <div class="product-detail_info--footer-count">
                        <div class="input-count">
                            <button @click="updateCartProduct(cartID, 'minus')">-</button>
                            <input type="number" :value="props.product.quantity" maxlength="99">
                            <button @click="updateCartProduct(cartID, 'plus')">+</button>
                        </div>
                    </div>
                </div>
                <div class="cart-item_footer_price">{{ product.price }} ₽</div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {router} from "@inertiajs/vue3";
const props = defineProps({
    product: Array,
    cartID: Number,
})

const updateCartProduct = (id, action) => {
    router.put(route('cart.update'), {
        id: id,
        action: action
    }, {
        preserveScroll: true,
        onSuccess: () => console.log(1),
        onFinish: () => console.log(2),
    })
}

const removeCartProduct = (id) => {
    router.post(route('cart.remove', id), {}, {
        preserveScroll: true,
        onSuccess: () => console.log(1),
        onFinish: () => console.log(2),
    });
}
</script>
