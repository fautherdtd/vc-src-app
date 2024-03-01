<template>
    <AppLayout title="Оформление заказа">
        <BreadCrumbs :child="[
            {id: 1, title: 'Корзина', link: 'cart.index'},
            {id: 2, title: 'Оформление заказа', link: 'cart.order'},
        ]"/>
        <div class="container">
            <h1 class="page-title">ОФОРМЛЕНИЕ ЗАКАЗА</h1>
            <form class="order-form" v-if="!formProcess"
                  @submit.prevent="createOrder">
                <div class="order-form_block order-form_block-main">
                    <div class="order-form_block--child">
                        <div class="order-form_block--child--title">Способ доставки</div>
                        <div class="order-form_block--child--content">
                            <label :for="ship.method" class="input-label"
                                   v-for="ship in props.delivery.data"
                                   :key="ship.id">
                                <input type="radio"
                                       v-model="form.delivery.method"
                                       :value="ship.method"
                                       name="delivery" :id="ship.method">
                                <p class="inp-radio-primary">{{ ship.label}}</p>
                            </label>
                            <InputError style="margin: 0" :message="form.errors['delivery.method']" />
                        </div>
                        <div class="order-form_block--child--content" v-if="buyerSelf">
                            <div class="order-form_block--child--content--sublink">
                                <p>
                                    Заказ можно забрать по адресу:
                                    <a href="https://yandex.ru/profile/-/CDeQv0IX" target="_blank">
                                        <ion-icon name="location-outline"></ion-icon>
                                        г. Дербент, ул. Кобякова, 12
                                    </a>
                                </p>
                            </div>
                        </div>
                        <template v-if="form.delivery.method !== 'self'">
                            <div class="order-form_block--child--content">
                                <input type="text"
                                       v-model="form.delivery.address"
                                       placeholder="Адрес доставки *" style="width: 100%" class="inp-text-primary">
                                <ul class="address-dadata" v-if="addressSuggest.length > 0">
                                    <li class="address-dadata_item"
                                        @click="changeAddress(suggest)"
                                        v-for="(suggest, key) in addressSuggest">
                                        <input type="radio" :id="'addressSuggest' + key" name="address" :value="suggest.text" />
                                        <label :for="'addressSuggest' + key">{{ suggest.text }}</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="order-form_block--child--content">
                                <label for="">
                                    <input type="text" v-model="form.delivery.sub.entrance" placeholder="Подъезд *" class="inp-text-primary inp-w-20">
                                </label>
                                <label for="">
                                    <input type="text" v-model="form.delivery.sub.floor" placeholder="Этаж *" class="inp-text-primary inp-w-20">
                                </label>
                            </div>
                            <div class="order-form_block--child--content">
                                <label for="">
                                    <input type="text" v-model="form.delivery.sub.apartment" placeholder="Квартира *" class="inp-text-primary inp-w-20">
                                </label>
                                <label for="">
                                    <input type="text" v-model="form.delivery.sub.intercom" placeholder="Домофон" class="inp-text-primary inp-w-20">
                                </label>
                            </div>
                        </template>
                        <div class="order-form_block--child--content" v-if="!buyerSelf">
                            <label class="input-label" for="selfAddress">
                                <input type="checkbox" v-model="selfAddress" name="selfAddress" id="selfAddress">
                                <p class="inp-radio-primary">Узнать адрес самостоятельно (свяжемся с получателем)</p>
                            </label>
                        </div>
                        <InputError class="mt-2" :message="form.errors['delivery.address']" />
                    </div>
                    <div class="order-form_block--child">
                        <div class="order-form_block--child--title">
                            Дата и время <template v-if="!buyerSelf">доставки</template>
                            <span v-if="!buyerSelf">Курьер позвонит по указанному номеру за час до доставки.</span>
                        </div>
                        <div class="order-form_block--child--content">
                            <div class="select-date--picker">
                                <div class="select-date--picker_text" @click="dateBody = !dateBody">
                                    <span v-if="form.timeDelivery.date === null">Дата доставки</span>
                                    <div class="select-date--picker_text--active" v-else>
                                        <span class="select-date--picker_text--active-label">Время доставки</span>
                                        <span class="select-date--picker_text--active-time">{{ form.timeDelivery.date }}</span>
                                    </div>
                                </div>
                                <div class="select-date--body" v-if="dateBody === true">
                                    <VDatePicker transparent borderless
                                                 mode="date"
                                                 :min-date='new Date()'
                                                 :masks="masksDate"
                                                 v-model.string="form.timeDelivery.date"/>
                                </div>
                            </div>
                            <div class="select-time--picker">
                                <div class="select-time--picker_text" @click="timesBody = !timesBody">
                                    <span v-if="form.timeDelivery.time === null">Время доставки</span>
                                    <div class="select-time--picker_text--active" v-else>
                                        <span class="select-time--picker_text--active-label">Время доставки</span>
                                        <span class="select-time--picker_text--active-time">{{ form.timeDelivery.time }}</span>
                                    </div>
                                </div>
                                <ul class="select-time--body" v-if="timesBody === true">
                                    <li class="select-time_item"
                                        @click="form.timeDelivery.time = time; timesBody = false;"
                                        v-for="(time, key) in slotsTime">
                                        <label :for="'time-' + key">
                                            {{ time }}
                                            <input type="radio" :id="'time-' + key" name="time" :value="time" />
                                        </label>
                                    </li>
                                </ul>
                            </div>
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
                                <input type="text" minlength="11" maxlength="11" v-model="form.contacts.from.phone" placeholder="Ваш телефон *" class="inp-text-primary inp-w-20">
                            </label>
                        </div>
                        <InputError class="mt-2" :message="form.errors['contacts.from.name']" />
                        <InputError class="mt-2" :message="form.errors['contacts.from.phone']" />
                        <div class="order-form_block--child--content">
                            <label class="input-label" for="buyerSelf">
                                <input type="checkbox" v-model="buyerSelf" name="buyerSelf" id="buyerSelf">
                                <p class="inp-radio-primary">Получатель я сам(а)</p>
                            </label>
                        </div>
                        <template v-if="!buyerSelf">
                            <div class="order-form_block--child--title"
                                 style="margin-top: 18px;">
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
                            <div class="order-form_block--child--content">
                                <label class="input-label" for="anonymous">
                                    <input type="checkbox" v-model="form.anonymous" name="anonymous" id="anonymous">
                                    <p class="inp-radio-primary">Анонимный заказ <i>(мы не скажем получателю о вас)</i></p>
                                </label>
                            </div>
                        </template>
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
                                <input type="radio" v-model="form.payment.method" :value="payment.method" name="payment" :id="payment.method">
                                <span class="inp-radio-primary">{{ payment.label }}</span>
                            </label>
                        </div>
                        <InputError class="mt-2" :message="form.errors['payment.method']" />
                    </div>
                </div>
                <div class="order-form_block  order-form_block-sub">
                    <div class="order-form_block--child">
                        <p class="text-small_info">
                            Вы также можете добавить приятные слова к своему заказу.
                            <br>Выбрать открытку можете в <Link :href="route('catalog', 'otkrytki')">каталоге</Link>.
                        </p>
                        <div class="order-form_block--child--content" style="margin: 0;">
                        <textarea name="" id=""
                                  v-model="form.message"
                                  class="inp-text-primary inp-textarea-primary"
                                  placeholder="Комментарий к заказу"></textarea>
                        </div>
                        <InputError class="mt-2" :message="form.errors.message" />
                        <div class="order-form_block--child--content">
                            <label for="rules" class="input-label">
                                <input type="checkbox" v-model="form.rules" value="rules" name="rules" id="rules">
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
                                    <span>{{ $page.props.share.cart.totalQuantity }} товар(а) на сумму</span>
                                    <span>{{ $page.props.share.cart.totalPrice }} ₽</span>
                                </div>
                                <div class="order-form_block--child--table_item">
                                    <span>доставка</span>
                                    <span>{{ form.delivery.price }} ₽</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="order-form_block--child--content">
                            <div class="order-form_block--child--table">
                                <div class="order-form_block--child--table_item">
                                    <h1>ИТОГО:</h1>
                                    <h2>{{ totalPrice }} ₽</h2>
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
            <div v-else>
                Ваш заказ оформлен.
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import {router, useForm, Link, usePage} from "@inertiajs/vue3";
import {ref, watch, onMounted} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import BreadCrumbs from "@/Components/Common/BreadCrumbs.vue";
import axios from "axios";
import InputError from "@/Components/Inputs/InputError.vue";
import distancePrice from "@/Mixins/DeliveryPrice.js";

const props = defineProps({
    delivery: Array,
    payments: Array,
    times: Object
});

const form = useForm({
    delivery: {
        method: 'courier',
        price: 0,
        address: null,
        sub: {
            entrance: null,
            floor: null,
            apartment: null,
            intercom: null,
        }
    },
    payment: {
        method: 'online-card'
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
    anonymous: false,
    message: null,
    rules: true,
    total: null,
})

const addressSuggest = ref([]);
const address = ref(null)
const masksDate = ref({
    modelValue: 'DD.MM.YYYY',
});
const tempDistance = ref({});
const totalPrice = ref(usePage().props.share.cart.totalPrice);
watch(() => form.delivery.address, (current, old) => {
    axios.post('https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address', {
        query: form.delivery.address,
        "locations_geo": [{
            "lat": 42.057669,
            "lon": 48.288776,
            "radius_meters": 38000
        }]
    }, {
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Token 4dcd1419b5dd26819456ea95743d1fa70a42d844"
        },
    }).then(response => {
        response.data.suggestions.forEach((element) => {
            addressSuggest.value.unshift({
                value: element.value,
                text: element.value,
                kladr_id: element.data.city_kladr_id,
                distance: {
                    "latitude": element.data.geo_lat,
                    "longitude": element.data.geo_lon,
                }
            });
        })
    })
})
const changeAddress = function (text) {
    tempDistance.value = text;
    if (text.kladr_id == '0500000600000') {
        form.delivery.price = 250;
        totalPrice.value = usePage().props.share.cart.totalPrice + 250;
    } else {
        tempDistance.value = text.distance;
        const price = distancePrice(text.distance);
        form.delivery.price = price;
        totalPrice.value = usePage().props.share.cart.totalPrice + price
    }
    form.total = totalPrice.value;
    form.delivery.address = text.value;
    addressSuggest.value = [];
}

const formProcess = ref(false);
const buyerSelf = ref(false);
const selfAddress = ref(false)
const timesBody = ref(false)
const dateBody = ref(false)
const slotsTime = ref({});
const createOrder = () => {
    form.post(route('cart.createOrder'), {
        preserveScroll: true,
        onSuccess: (data) => {
            console.log(data)
            formProcess.value = true
        }
    });
}

watch(() => form.delivery.method, (current) => {
    if (current === 'self') {
        buyerSelf.value = true
        form.delivery.price = 0
        form.delivery.address = null;
        selfAddress.value = false;
        totalPrice.value = usePage().props.share.cart.totalPrice
    } else {
        buyerSelf.value = false;
    }
})
watch(() => form.timeDelivery.date, (current) => {
    form.timeDelivery.time = null;
    getTimeSlots(current)
    dateBody.value = false;
})
onMounted(() => {
    getTimeSlots(new Date().toISOString().slice(0,10))
});

const getTimeSlots = (string) => {
    axios.get(route('cart.timeSlots'), {
        params: { date:  string }
    }).then(data => slotsTime.value = data.data)
}
</script>
