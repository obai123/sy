<!-- resources/js/Pages/Welcome.vue -->
<template>
    <main-layout>
        <ListCategories :categories="categories" />
    </main-layout>
</template>

<script setup>
import ListCategories from "@/Pages/Category/ListCategories.vue";
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});
</script>
