<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    title: String,
    logo: String,
});


</script>

<template>
    <div>
        <Head :title="title" />


        <div class="min-h-screen bg-gray-100">
            <!-- Page Content -->
            <main>
                <slot />
            </main>

        </div>
    </div>
</template>
