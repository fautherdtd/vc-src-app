<template>
    <div class="modal-item">
        <div class="banner-src"
             :style="'background-image: url(' + this.img + ')'"></div>
    </div>
</template>
<script>
export default {
    props: {
        title: String,
        img: String
    }
}
</script>
<style scoped>
.modal-item {
    width: 600px;
    height: 400px;
    background-color: #fff;
}
.banner-src {
    width: 100%;
    height: 100%;
    background-size: cover;
}
@media (max-width: 425px) {
    .modal-item {
        width: 90%;
        height: 300px;
    }
}
</style>
