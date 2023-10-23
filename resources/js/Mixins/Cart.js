import {router} from "@inertiajs/vue3";

const addToCart = (id, params) => {
    router.post(route('cart.add'), {
        id: id,
        price: params.price,
        count: params.count
    }, {
        preserveScroll: true,
        onSuccess: () => {

        },
        onFinish: () => {},
    })
}

export default addToCart;
