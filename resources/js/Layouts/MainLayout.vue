<script setup>
import Header from "@/Components/Header.vue";
</script>

<template>
    <Header />

    <div class="container mx-auto px-2 my-8">
        <slot/>
    </div>
</template>
