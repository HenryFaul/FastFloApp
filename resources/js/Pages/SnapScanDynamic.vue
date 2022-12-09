<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {useForm} from "@inertiajs/inertia-vue3";
import PrimaryButton from '@/Components/SnapButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import {computed, reactive, ref} from "vue";
import {Inertia} from "@inertiajs/inertia";

const display_message = ref(true);

const props = defineProps({
    price: String,
    snap_url: String,
    snap_button_url: String,
    machine: String,
    du:String,
    id:String

})

const form = useForm({
    qty: 1,
    du_no: props.du,
    paymentRef: '',
    scan_url: '',
    id:props.id

});
const charge = computed(() => form.qty * props.price)

const paymentRef = () => {
    form.paymentRef = props.machine + "_" + Date.now().toString();
}
const reloadPage = () => {
    display_message.value = true;
    paymentRef();
    Inertia.reload({only: ['']});
}
const paymentCharge = () => {
    return form.qty * props.price
}

const increaseQty = () => {
    form.qty = form.qty + 1;
}

const decreaseQty = () => {
    if (form.qty > 1) {
        form.qty = form.qty - 1;
    }
}

const submitPay = () => {

    paymentRef();
    form.scan_url = props.snap_button_url + "id=" + form.paymentRef + "&amount=" + paymentCharge();

    window.open(form.scan_url);
    form.transform(data => ({
        ...data,
    })).post(route('payment.notification'), {});

};


</script>

<template>
    <GuestLayout title="SnapScan">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                SnapScan
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div >
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                            <div class="flex justify-center">
                                {{props.machine}}:{{props.du}}
                                <img :src="$page.props.app_logo_dark" alt="logo">
                            </div>
                        </div>

                        <div class="flex justify-center">

                            <div class="p-2 sm:px-20 bg-white border-b border-gray-200">

                                <div v-if="$page.props.ngrok_running">
                                    <div v-if="!form.processing">
                                        <div class="mt-2 ml-4 mr-4 pl-3 pr-3 flex justify-center">

                                            <table class="table">

                                                <tbody>
                                                <tr class="">
                                                    <td></td>
                                                    <td>
                                                        <div class="text-xl flex justify-center underline font-bold">
                                                            Quantity
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="">
                                                    <td class="">

                                                        <button @click="decreaseQty()" type="button"
                                                                class="inline-block px-6 py-2.5 bg-yellow-500 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-yellow-600 hover:shadow-lg focus:bg-yellow-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-yellow-700 active:shadow-lg transition duration-150 ease-in-out">
                                                            <div class="text-xl font-bold">-</div>
                                                        </button>



                                                    </td>
                                                    <td>
                                                        <div class="text-6xl font-bold flex justify-center">
                                                            {{ form.qty }}
                                                        </div>
                                                    </td>
                                                    <td class="">
                                                        <button @click="increaseQty()" type="button"
                                                                class="inline-block px-6 py-2.5 bg-yellow-500 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-yellow-600 hover:shadow-lg focus:bg-yellow-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-yellow-700 active:shadow-lg transition duration-150 ease-in-out">
                                                            <div class="text-xl font-bold">+</div>
                                                        </button>
                                                    </td>
                                                </tr>

                                                <tr class="">
                                                    <td></td>
                                                    <td class="">
                                                        <div class="text-4xl font-bold flex justify-center">R
                                                            {{ charge / 100 }}
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>

                                                <tr class="">
                                                    <td></td>
                                                    <td class="">

                                                        <div class="mt-2 flex justify-center">
                                                            <PrimaryButton @click="submitPay" class="ml-4"
                                                                           :class="{ 'opacity-25': form.processing }"
                                                                           :disabled="form.processing">
                                                                Pay with
                                                                <img  :src="$page.props.snap_scan" style="width: 200px" alt="logo"/>
                                                            </PrimaryButton>

                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div v-if="form.processing ">

                                        <div class="flex items-center justify-center space-x-2">
                                            <div
                                                class="spinner-border animate-spin inline-block w-12 h-12 border-4 rounded-full"
                                                role="status">
                                                <span class="visually-hidden">.</span>
                                            </div>

                                        </div>


                                        <div class="mt-2 flex justify-center">
                                            <DangerButton @click="reloadPage()" class="ml-4"
                                                          :class="{ 'opacity-25': !form.processing }"
                                                          :disabled="!form.processing">
                                                Cancel Payment
                                            </DangerButton>
                                        </div>
                                    </div>

                                    <div v-if="form.paymentRef===$page.props.Custom_flash.cur_payment_ref">
                                        <div
                                            v-if="$page.props.Custom_flash.status ==='success'"
                                            class="mt-2">

                                            <div
                                                class="bg-blue-100 rounded-lg py-5 px-6 mb-4 text-base text-blue-700 mb-3"
                                                role="alert">
                                                {{ $page.props.Custom_flash.message }}
                                            </div>

                                        </div>

                                        <div
                                            v-if="$page.props.Custom_flash.status ==='error' "
                                            class="mt-2">

                                            <div
                                                class="bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3"
                                                role="alert">
                                                {{ $page.props.Custom_flash.message}}
                                            </div>

                                        </div>
                                    </div>


                                </div>
                                <div v-else>

                                    <div>
                                        <div class="bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3" role="alert">
                                            Seems that the pouring machine is not online. Please inform the staff.
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>

        </div>



    </GuestLayout>
</template>
