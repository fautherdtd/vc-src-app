import {router} from "@inertiajs/vue3";

const addToFavorite = (id, type) => {
    router.post(route('favorites.add'), {
        id: id,
        type: type
    }, {
        preserveScroll: true,
        onSuccess: () => {},
        onFinish: () => {},
    })
}

export default addToFavorite;
