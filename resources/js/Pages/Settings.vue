<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';

import UpdateSettingsForm from '@/Pages/Settings/UpdateSettingsForm.vue';
import {computed} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";


import {ref} from 'vue';
import {Inertia} from '@inertiajs/inertia';
import {Link, useForm} from '@inertiajs/inertia-vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    flo_settings: {
        type: Object,
        required: true
    }
});
const page_props = computed(() => usePage().props);


const form = useForm({
    _method: 'PUT',
    machine: props.flo_settings.machine,
    du_no:props.flo_settings.du_no,
    flo_url:props.flo_settings.flo_url,
    scan_url:props.flo_settings.scan_url,
    unit_price:props.flo_settings.unit_price,
    snap_code:props.flo_settings.snap_code,
    snap_api_key:props.flo_settings.snap_api_key,
    snap_webhook_key:props.flo_settings.snap_webhook_key,
    flo_active:props.flo_settings.flo_active,


});

const updateSettingsInformation = () => {

     form.post(route('settings.update'), {
         preserveScroll: true,
         onSuccess: () => alert('updated'),
     });
};

</script>

<template>
    <AppLayout title="Settings">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">


                        <div class="mt-8 text-2xl">
                            Settings
                        </div>

                        <div class="mt-6">

                            <FormSection @submitted="updateSettingsInformation">
                                <template #title>
                                    Fastflo Configuration
                                </template>

                                <template #description>
                                    Update your Fastflo Configuration!
                                </template>


                                <template #form>
                                    <!-- Machine -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <InputLabel for="name" value="Machine"/>
                                        <TextInput
                                            id="machine"
                                            v-model="form.machine"
                                            type="text"
                                            class="mt-1 block w-full"
                                        />
                                        <InputError :message="form.errors.machine" class="mt-2"/>
                                    </div>

                                    <!-- DU No -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <InputLabel for="name" value="DU No"/>
                                        <TextInput
                                            id="du_no"
                                            v-model="form.du_no"
                                            type="text"
                                            class="mt-1 block w-full"
                                        />
                                        <InputError :message="form.errors.du_no" class="mt-2"/>
                                    </div>

                                    <!-- Flo URL -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <InputLabel for="name" value="Flo Url"/>
                                        <TextInput
                                            id="flo_url"
                                            v-model="form.flo_url"
                                            type="text"
                                            class="mt-1 block w-full"
                                        />
                                        <InputError :message="form.errors.flo_url" class="mt-2"/>
                                    </div>

                                    <!-- Flo URL -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <InputLabel for="name" value="Scan Url"/>
                                        <TextInput
                                            id="scan_url"
                                            v-model="form.scan_url"
                                            type="text"
                                            class="mt-1 block w-full"
                                        />
                                        <InputError :message="form.errors.scan_url" class="mt-2"/>
                                    </div>

                                    <!-- Unit Price -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <InputLabel for="name" value="Unit Price (Cents)"/>
                                        <TextInput
                                            id="unit_price"
                                            v-model="form.unit_price"
                                            type="text"
                                            class="mt-1 block w-full"
                                        />
                                        <InputError :message="form.errors.unit_price" class="mt-2"/>
                                    </div>

                                    <!-- Snap Code -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <InputLabel for="name" value="Snap Code"/>
                                        <TextInput
                                            id="snap_code"
                                            v-model="form.snap_code"
                                            type="text"
                                            class="mt-1 block w-full"
                                        />
                                        <InputError :message="form.errors.snap_api_key" class="mt-2"/>
                                    </div>
                                    <!-- Snap API key -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <InputLabel for="name" value="Snap API key"/>
                                        <TextInput
                                            id="snap_api_key"
                                            v-model="form.snap_api_key"
                                            type="text"
                                            class="mt-1 block w-full"
                                        />
                                        <InputError :message="form.errors.snap_api_key" class="mt-2"/>
                                    </div>


                                    <!-- Snap Webhook key -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <InputLabel for="name" value="Snap API key"/>
                                        <TextInput
                                            id="snap_webhook_key"
                                            v-model="form.snap_webhook_key"
                                            type="text"
                                            class="mt-1 block w-full"
                                        />
                                        <InputError :message="form.errors.snap_webhook_key" class="mt-2"/>
                                    </div>


                                    <!-- Snap Webhook key -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <InputLabel for="name" value="Flo Active"/>
                                        <TextInput
                                            id="flo_active"
                                            v-model="form.flo_active"
                                            type="text"
                                            class="mt-1 block w-full"

                                        />
                                        <InputError :message="form.errors.flo_active" class="mt-2"/>
                                    </div>


                                </template>

                                <template #actions>
                                    <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                                        Saved.
                                    </ActionMessage>

                                    <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                                   :disabled="form.processing">
                                        Save
                                    </PrimaryButton>
                                </template>

                            </FormSection>


                        </div>


                    </div>


                </div>
            </div>
        </div>
    </AppLayout>
</template>
