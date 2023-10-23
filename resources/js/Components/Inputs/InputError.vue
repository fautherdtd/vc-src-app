<script setup>
defineProps({
    message: String,
});
</script>

<template>
    <div v-show="message" class="input-error">
        <p class="text-sm text-red-600">
            {{ message }}
        </p>
    </div>
</template>
