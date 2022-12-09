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

                <ul class="mt-5">
                    <li>
                        <Link :href="route('snapscan.payment','1')" class="text-xl font-bold text-gray-700 dark:text-gray-500 underline">SnapScan DU1</Link>

                    </li>

                    <li>
                        <Link :href="route('snapscan.payment','2')" class="text-xl font-bold text-gray-700 dark:text-gray-500 underline">SnapScan DU2</Link>

                    </li>
                </ul>




            </div>
        </div>


    </div>
</template>
