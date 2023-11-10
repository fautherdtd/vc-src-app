import {router} from "@inertiajs/vue3";

const addToFavorite = (id) => {
    router.post(route('favorites.add'), {
        id: id
    }, {
        preserveScroll: true,
        onSuccess: () => {},
        onFinish: () => {},
    })
}

export default addToFavorite;
