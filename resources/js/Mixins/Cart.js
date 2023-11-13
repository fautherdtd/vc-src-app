import {router} from "@inertiajs/vue3";
import { useNotification } from "@kyvg/vue3-notification";
const { notify }  = useNotification()

const addToCart = (id, params) => {
    router.post(route('cart.add'), {
        id: id,
        price: params.price,
        count: params.count,
        type: params.type ?? 'product'
    }, {
        preserveScroll: true,
        onSuccess: () => {
            notify({
                type: "success",
                title: "Товар добавлен в корзину!",
            });
        },
        onFinish: () => {
        },
    })
}

export default addToCart;
