<script setup>
import Banner from '@/Components/Banner.vue';
import {useForm} from "@inertiajs/inertia-vue3";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import {computed, reactive, ref} from "vue";

defineProps({
    price: Number
});

const form = useForm({
    qty: 1,
    email: '',
    password: '',
    remember: false,
});

const charge = computed(() => form.qty * 30)


const payment_loading = ref(false);

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
    <div>

        <div class="p-6 sm:px-20 bg-gray-400 border-b border-gray-200">
            <div class="flex justify-center">
                <img :src="'logos/flo.png'" alt="logo">
            </div>
        </div>

        <div class="flex justify-center">

            <div class="p-2 sm:px-20 bg-white border-b border-gray-200">
                <div>

                    <div class="">
                        <div class="mt-2 flex justify-center">

                            <table class="table w-full whitespace-nowrap p-20">

                                <tbody>
                                <tr class="">
                                    <td></td>
                                    <td>
                                        <div class="text-xl flex justify-center underline font-bold">Quantity</div>
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
                                        <div class="text-6xl font-bold flex justify-center">{{ this.form.qty }}</div>
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
                                        <div class="text-4xl font-bold flex justify-center">R {{this.charge}}</div>
                                    </td>
                                    <td></td>
                                </tr>

                                <tr class="">
                                    <td></td>
                                    <td class="p-6">
                                        <div class="mt-2 flex justify-center">
                                            <PrimaryButton @click="submitPay" class="ml-4"
                                                           :class="{ 'opacity-25': form.processing }"
                                                           :disabled="form.processing">
                                                PayNow
                                            </PrimaryButton>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="">

                        <div class="flex justify-center items-center">
                            <div class="spinner-border animate-spin inline-block w-8 h-8 border-4 rounded-full"
                                 role="status">
                                <span class="visually-hidden">.</span>
                            </div>
                        </div>


                        <div class="mt-2 text-4xl flex justify-center">
                            <a href="https://pos.snapscan.io/qr/shopalot?id=Ord123&amount=1000">
                                <img style="width: 300px"
                                     src="https://pos.snapscan.io/qr/shopalot.svg?id=Ord123&amount=100&snap_code_size=300"
                                     alt="snap_code">
                            </a>

                        </div>


                        <div class="mt-2">
                            <Banner/>
                        </div>

                        <div class="mt-2 flex justify-center">
                            <PrimaryButton @click="submitPay" class="ml-4" :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing">
                                PayNow
                            </PrimaryButton>
                        </div>

                        <div class="mt-2 flex justify-center">
                            <DangerButton @click="submitPay" class="ml-4" :class="{ 'opacity-25': form.processing }"
                                          :disabled="form.processing">
                                Cancel Payment
                            </DangerButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>
