<script setup>
import {Head} from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import CardDetailsForm from "@/Pages/Transaction/Partials/forms/CardDetailsForm.vue";
import PaymentProof from "@/Pages/Transaction/Partials/PaymentProof.vue";
import FiftyText from "@/Components/Design/FiftyText.vue";
import TransactionSteps from "@/Pages/Transaction/Partials/TransactionSteps.vue";

const props = defineProps({
    user: {
        default: null,
        type: Object,
        required: true
    },
    paymentIntent: {
        default: null,
        type: Object
    },
    stripeConfig: {
        default: null,
        type: Object
    }
})


</script>

<template>
    <GuestLayout>
        <Head title="Fifty-Fifty | Send Money">
            <title>
                Fifty-Fifty | Make Payment
            </title>
        </Head>

        <div class="transaction-step-wrapper">
            <div class="transaction-step">
                <TransactionSteps current-step="card-info" />

                <FiftyText variation="heading-3">
                    Card Details
                </FiftyText>

                <transition mode="out-in" name="fade">
                    <PaymentProof
                        v-if="!!props.user.transaction_id"
                        :receiver="props.user.handled_transaction.receiver"
                        :user="props.user"
                    />

                    <CardDetailsForm v-else :paymentIntent="paymentIntent" :stripeConfig="stripeConfig"/>
                </transition>
            </div>
        </div>
    </GuestLayout>
</template>

<script>
export default {
    name: 'Payment'
}
</script>
