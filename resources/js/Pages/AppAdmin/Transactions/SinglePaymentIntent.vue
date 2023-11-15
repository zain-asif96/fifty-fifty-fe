<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, router, Link} from '@inertiajs/vue3';
import {useHelpers} from "@/Composables/useHelpers";
import SimpleButton from "@/Components/Custom/SimpleButton.vue";

const props = defineProps({
    paymentIntent: {
        required: true,
        type: Object
    }
})


const helpers = useHelpers()

const replaceImageSrc = (e) => {
    console.log("error")
    e.target.src = '/images/image-not-found.png';
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
                        {{ parseFloat(props.paymentIntent.amount / 100).toFixed(2) }}
                    </div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Currency:</div>
                    <div class="font-semibold uppercase">
                        {{ props.paymentIntent.currency }}
                    </div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Stripe reference identification:</div>
                    <div class="font-semibold uppercase">
                        {{ props.paymentIntent.stripe_payment_intent_id }}
                    </div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Status:</div>
                    <div class="font-semibold uppercase">
                        {{ props.paymentIntent.status }}
                    </div>
                </div>

                <div class="flex items-center mt-8 mb-8">
                    <div class="w-48">Payment proof:</div>
                    <div class="font-semibold uppercase">
                        <img :class="{'w-16' : !props.paymentIntent.payment_proof}"
                             :src="props.paymentIntent.payment_proof || '/images/image-not-found.png'"
                             alt="payment proof" class="max-w-xs"
                             @error="replaceImageSrc">
                    </div>
                </div>


                <div class="flex mt-2">
                    <div class="w-32">Created at:</div>
                    <div class="font-semibold">{{ props.paymentIntent.created_at }}</div>
                </div>
            </div>


            <SimpleButton @click="router.get(route('transactions.page'))">
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
