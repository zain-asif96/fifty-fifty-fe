<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router, Link } from '@inertiajs/vue3';
import { useHelpers } from "@/Composables/useHelpers";
import SimpleButton from "@/Components/Custom/SimpleButton.vue";
import { onMounted, ref } from "vue";
import { request } from "@/helpers/requestHelper.js";

const props = defineProps({
    paymentIntent: {
        required: true,
        type: Object
    }
})


const helpers = useHelpers()
const singleTransaction = ref({})

const replaceImageSrc = (e) => {
    console.log("error")
    e.target.src = '/images/image-not-found.png';
}

onMounted(() => {
    getTransaction(props?.paymentIntent)
})

const getTransaction = async (id = '',) => {
    let params = id

    try {
        let res = await request({ type: 'get', url: `transactions/track`, params })
        console.log({ res });
        if (res?.data?.data) {
            let data = res?.data?.data?.data
            let col = new URLSearchParams(window.location.search).get('column');
            let type = new URLSearchParams(window.location.search).get('type');
            if (col && type) {
                if (type === 'asc') {
                    data = data?.sort((a, b) => a[col].localeCompare(b[col]));

                } else {
                    data = data?.sort((a, b) => b[col].localeCompare(a[col]));

                }
            }

            singleTransaction.value = { ...res?.data?.data, data }
            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}
</script>


<template>
    <Head title="Single PaymentIntent">
        <title>
            Single PaymentIntent
        </title>
    </Head>

    <AdminLayout>
        <div class="ml-4 md:ml-16">
            <div class="mt-16 mb-8 text-xl flex items-center justify-between">
                <div>
                    <span class="text-gray-500">Payment Intent</span>
                </div>
            </div>

            <div class="flex flex-col mt-12 mb-12">
                <div class="flex mt-2">
                    <div class="w-48">Amount:</div>
                    <div class="font-semibold">
                        {{ !isNaN(parseFloat(singleTransaction.receiver_amount /
                            100).toFixed(2)) ? parseFloat(singleTransaction.receiver_amount / 100).toFixed(2) : '' }}
                    </div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Currency:</div>
                    <div class="font-semibold uppercase">
                        {{ singleTransaction.receiver_currency }}
                    </div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Stripe reference identification:</div>
                    <div class="font-semibold uppercase">
                        {{ singleTransaction.transaction_id }}
                    </div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Status:</div>
                    <div class="font-semibold uppercase">
                        {{ singleTransaction.pairing_status }}
                    </div>
                </div>

                <div class="flex items-center mt-8 mb-8">
                    <div class="w-48">Payment proof:</div>
                    <div class="font-semibold uppercase">
                        <img :class="{ 'w-16': !singleTransaction.transaction_config?.payment_proof }"
                            :src="singleTransaction.transaction_config?.payment_proof || '/images/image-not-found.png'"
                            alt="payment proof" class="max-w-xs" @error="replaceImageSrc">
                    </div>
                </div>


                <div class="flex mt-2">
                    <div class="w-32">Created at:</div>
                    <div class="font-semibold">{{ singleTransaction?.created_at }}</div>
                </div>
            </div>


            <SimpleButton @click="router.get(route('app.transactions.page'))">
                Back to transactions list
            </SimpleButton>

        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: 'SinglePaymentIntent'
}
</script>
