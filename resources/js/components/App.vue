<template>
    <router-view :key="$route.fullPath"></router-view>
</template>

<script>
    export default {
        name: "App.vue"
    }
</script>

<style scoped>

</style>
