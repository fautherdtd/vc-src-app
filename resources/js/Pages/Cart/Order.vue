<template>
    <AppLayout title="Оформление заказа">
        <BreadCrumbs :child="[
            {id: 1, title: 'Корзина', link: 'cart.index'},
            {id: 2, title: 'Оформление заказа', link: 'cart.order'},
        ]"/>
        <div class="container">
            <h1 class="page-title">ОФОРМЛЕНИЕ ЗАКАЗА</h1>
            <form class="order-form" @submit.prevent="createOrder">
                <div class="order-form_block order-form_block-main">
                    <div class="order-form_block--child">
                        <div class="order-form_block--child--title">Способ доставки</div>
                        <div class="order-form_block--child--content">
                            <label :for="ship.method" class="input-label"
                                   v-for="ship in props.delivery.data"
                                   :key="ship.id">
                                <input type="radio" :model="form.delivery.method" :value="ship.method" name="delivery" :id="ship.method">
                                <p class="inp-radio-primary">{{ ship.label}}</p>
                            </label>
                            <InputError style="margin: 0" :message="form.errors['delivery.method']" />
                        </div>
                        <div class="order-form_block--child--content">
                            <input type="text" v-model="form.delivery.address" placeholder="Адрес доставки *" style="width: 100%" class="inp-text-primary">
                            <ul class="address-dadata" v-if="addressSuggest.length > 0">
                                <li class="address-dadata_item"
                                    @click="changeAddress(suggest.text)"
                                    v-for="(suggest, key) in addressSuggest">
                                    <input type="radio" :id="'addressSuggest' + key" name="address" :value="suggest.text" />
                                    <label :for="'addressSuggest' + key">{{ suggest.text }}</label>
                                </li>
                            </ul>
                        </div>
                        <InputError class="mt-2" :message="form.errors['delivery.address']" />
                    </div>
                    <div class="order-form_block--child">
                        <div class="order-form_block--child--title">
                            Дата и время доставки
                            <span>Курьер позвонит по указанному номеру за час до доставки.</span>
                        </div>
                        <div class="order-form_block--child--content">
                            <label for="date" class="input-label">
                                <input type="date" id="date"
                                       v-model="form.timeDelivery.date"
                                       class="inp-text-primary">
                            </label>
                            <label for="time" class="input-label">
                                <input type="time" id="time"
                                       step="300"
                                       v-model="form.timeDelivery.time"
                                       :disabled="form.timeDelivery.date == null"
                                       class="inp-text-primary">
                            </label>
                        </div>
                        <InputError class="mt-2" :message="form.errors['delivery_time']" />
                    </div>
                    <div class="order-form_block--child">
                        <div class="order-form_block--child--title">
                            Контакты
                        </div>
                        <div class="order-form_block--child--content">
                            <label for="">
                                <input type="text" v-model="form.contacts.from.name" placeholder="Ваше имя *" class="inp-text-primary inp-w-20">
                            </label>
                            <label for="">
                                <input type="text" v-model="form.contacts.from.phone" placeholder="Ваш телефон *" class="inp-text-primary inp-w-20">
                            </label>
                        </div>
                        <InputError class="mt-2" :message="form.errors['contacts.from.name']" />
                        <InputError class="mt-2" :message="form.errors['contacts.from.phone']" />
                        <div class="order-form_block--child--title" style="margin-top: 18px;">
                            Получатель
                        </div>
                        <div class="order-form_block--child--content">
                            <label for="">
                                <input type="text" v-model="form.contacts.to.name" placeholder="Имя получателя *" class="inp-text-primary inp-w-20">
                            </label>
                            <label for="">
                                <input type="text" v-model="form.contacts.to.phone" placeholder="Телефон получателя *" class="inp-text-primary inp-w-20">
                            </label>
                        </div>
                        <InputError class="mt-2" :message="form.errors['contacts.to.name']" />
                        <InputError class="mt-2" :message="form.errors['contacts.to.phone']" />
                    </div>
                    <div class="order-form_block--child">
                        <div class="order-form_block--child--title">
                            Способ оплаты
                        </div>
                        <div class="order-form_block--child--content">
                            <label :for="payment.method" class="input-label"
                                   v-for="payment in props.payments.data"
                                   :key="payment.id">
                                <input type="radio" :model="form.payment.method" :value="payment.method" name="payment" :id="payment.method">
                                <p class="inp-radio-primary">{{ payment.label }}</p>
                            </label>
                        </div>
                        <InputError class="mt-2" :message="form.errors['payment.method']" />
                    </div>
                </div>
                <div class="order-form_block  order-form_block-sub">
                    <div class="order-form_block--child">
                        <div class="order-form_block--child--content" style="margin: 0;">
                        <textarea name="" id=""
                                  :model="form.message"
                                  class="inp-text-primary inp-textarea-primary"
                                  placeholder="Комментарий к заказу"></textarea>
                        </div>
                        <InputError class="mt-2" :message="form.errors.message" />
                        <div class="order-form_block--child--content">
                            <label for="rules" class="input-label">
                                <input type="checkbox" :model="form.rules" value="rules" name="rules" id="rules">
                                <p class="inp-radio-primary">Я даю согласие на обработку моих данных</p>
                            </label>
                        </div>
                        <InputError class="mt-2" :message="form.errors.rules" />
                    </div>
                    <div class="order-form_block--child">
                        <div class="order-form_block--child--title">
                            Ваш заказ
                        </div>
                        <div class="order-form_block--child--content">
                            <div class="order-form_block--child--table">
                                <div class="order-form_block--child--table_item">
                                    <span>2 товара на сумму</span>
                                    <span>13 780 ₽</span>
                                </div>
                                <div class="order-form_block--child--table_item">
                                    <span>доставка</span>
                                    <span>1 780 ₽</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="order-form_block--child--content">
                            <div class="order-form_block--child--table">
                                <div class="order-form_block--child--table_item">
                                    <h1>ИТОГО:</h1>
                                    <h2>13 780 ₽</h2>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            ОФОРМИТЬ ЗАКАЗ
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
<script setup>
import {router, useForm} from "@inertiajs/vue3";
import {defineComponent, ref, watch} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadCrumbs from "@/Components/Common/BreadCrumbs.vue";
import axios from "axios";
import InputError from "@/Components/Inputs/InputError.vue";

const props = defineProps({
    delivery: Array,
    payments: Array
});

const form = useForm({
    delivery: {
        method: null,
        address: null,
        price: null
    },
    payment: {
        method: null
    },
    timeDelivery: {
        date: new Date().toISOString().slice(0,10),
        time: null,
    },
    contacts: {
        from: {
            name: null,
            phone: null,
        },
        to: {
            name: null,
            phone: null
        }
    },
    message: null,
    rules: null,
})
const addressSuggest = ref([]);
watch(
    () => form.delivery.address,
    (query) => {
        axios.post('https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address', {
            query: query,
            "locations_geo": [{
                "lat": 42.057669,
                "lon": 48.288776,
                "radius_meters": 1000
            }]
        }, {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "Authorization": "Token 4dcd1419b5dd26819456ea95743d1fa70a42d844"
            },
        }).then(response => {
            response.data.suggestions.forEach((element) => {
                addressSuggest.value.push({
                    value: element.value,
                    text: element.value
                });
            })
        })
    }
)
const changeAddress = (text) => {
    form.delivery.address = text;
    addressSuggest.value = [];
}

const createOrder = () => {
    form.post(route('cart.createOrder'), {
        onSuccess: () => form.reset(),
    });
}
</script>
