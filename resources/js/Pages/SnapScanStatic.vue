<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {useForm} from "@inertiajs/inertia-vue3";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import {computed, reactive, ref} from "vue";
import {Inertia} from "@inertiajs/inertia";
import { Link } from '@inertiajs/inertia-vue3';

const display_message = ref(true);

const props = defineProps({
    price: String,
    snap_url: String,
    snap_button_url:String,
    machine: String,
})

const form = useForm({
    qty: 1,
    du_no:'DU1',
    paymentRef: '',
    scan_url: ''

});

//https://pos.snapscan.io/qr/shopalot?id=Ord123&amount=1000&strict=true

//const final_url = computed(() => props.snap_url + "id=" + form.paymentRef + "&amount=" + paymentCharge())

//const final_button_url = computed(() => props.snap_button_url + "id=" + form.paymentRef + "&amount=" + paymentCharge())

const btnUrl = () => {
    paymentRef();
    form.scan_url = props.snap_button_url + "id=" + form.paymentRef + "&amount=" + paymentCharge();
    return form.scan_url;
}

const charge = computed(() => form.qty * props.price)

const paymentRef = () => {
    form.paymentRef = props.machine + "_" + Date.now().toString();
}
const reloadPage = () => {
    display_message.value=true;
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

                    <div>

                        <div class="p-6 sm:px-20 bg-gray-400 border-b border-gray-200">
                            <div class="flex justify-center">
                                <img :src="'logos/flo.png'" alt="logo">
                            </div>
                        </div>

                        <div class="flex justify-center">

                            <div class="p-2 sm:px-20 bg-white border-b border-gray-200">
                                <div>

                                    <div v-if="!form.processing ">
                                        <div class="mt-2 flex justify-center">

                                            <table class="table w-full whitespace-nowrap p-20">

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
                                                    <td class="p-6">
                                                        <button @click="increaseQty()" type="button"
                                                                class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                                                            <div class="text-xl font-bold">+</div>
                                                        </button>

                                                    </td>
                                                    <td>
                                                        <div class="text-6xl font-bold flex justify-center">
                                                            {{ this.form.qty }}
                                                        </div>
                                                    </td>
                                                    <td class="p-6">
                                                        <button @click="decreaseQty()" type="button"
                                                                class="inline-block px-6 py-2 border-2 border-yellow-500 text-yellow-500 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                                                            <div class="text-xl font-bold">-</div>
                                                        </button>

                                                    </td>
                                                </tr>

                                                <tr class="">
                                                    <td></td>
                                                    <td class="p-6">
                                                        <div class="text-4xl font-bold flex justify-center">R
                                                            {{ charge / 100 }}
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>

                                                <tr class="">
                                                    <td></td>
                                                    <td class="p-6">

                                                        <div class="mt-2 flex justify-center">
                                                            <PrimaryButton @click="submitPay"  class="ml-4"
                                                                           :class="{ 'opacity-25': form.processing }"
                                                                           :disabled="form.processing">

<!--                                                                <Link target="_blank" :href=btnUrl()>Pay via SnapScan</Link>-->
                                                                <a :href=btnUrl() target="_blank">
                                                                    Pay via SnapScan
                                                                </a>
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

                                            <div class="bg-blue-100 rounded-lg py-5 px-6 mb-4 text-base text-blue-700 mb-3" role="alert">
                                                {{ $page.props.Custom_flash.message }}
                                            </div>

                                        </div>

                                        <div
                                            v-if="$page.props.Custom_flash.status ==='error' "
                                            class="mt-2">

                                            <div class="bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3" role="alert">
                                                {{ $page.props.Custom_flash.message }}
                                            </div>

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
