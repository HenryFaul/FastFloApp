<script setup>
import { Link } from '@inertiajs/inertia-vue3';


</script>

<template>
    <Link :href="'/'">
        <img :src="$page.props.app_logo" style="width: 200px" alt="logo">
    </Link>
</template>
