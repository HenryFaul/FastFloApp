<script setup>
import { Link } from '@inertiajs/inertia-vue3';

</script>

<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">


            <div class="mt-8 text-2xl">
                Welcome to your Fastflo payment app!
            </div>

            <div class="mt-6 text-gray-500">
                You can view payment stats or configure payment options.
            </div>

            <div class="mt-6 text-gray-500">
                To access new payments go to:

                <Link :href="route('snapscan.payment')" class="text-xl font-bold text-gray-700 dark:text-gray-500 underline">SnapScan</Link>
            </div>
        </div>


    </div>
</template>
