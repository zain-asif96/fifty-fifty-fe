<script setup>
import UploadPaymentProof from "@/Pages/Transaction/Partials/UploadPaymentProof.vue";
import FullReceiverItem from "@/Pages/Transaction/Partials/FullReceiverItem.vue";
import {currencies_countries} from "@/helpers/currencies_countries";
import {router} from "@inertiajs/vue3";
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    receiver: {
        required: true,
        type: Object
    },
    user: {
        required: true,
        type: Object
    }
})

const proofUploaded = (transaction) => {
    router.get('/track-transaction?transaction=' + transaction.id)
}

// Amount to be sent:

const amountInReceiverCurrency = parseFloat((props.user.handled_transaction.payment_intent.amount_in_receiver_currency / 100).toFixed(2));

</script>

<template>
    <div class="timeline-wrapper" style="margin-top: 18px;">
        <FiftyText variation="body-xl" color="dark">
            You don't have to enter any card details
        </FiftyText>

        <FiftyText>
            Please, pay
            <b> {{ amountInReceiverCurrency }} ({{ currencies_countries[user.handled_transaction.receiver.country] }})</b>
            to
            <b> {{ receiver.first_name }} {{ receiver.last_name }} </b>
            and upload The Payment Proof
        </FiftyText>

        <FullReceiverItem :receiver="receiver" class="m-auto"/>

        <UploadPaymentProof
            :transaction="user.handled_transaction"
            url="/upload-payment-proof"
            @uploaded="proofUploaded"
        />
    </div>
</template>

<script>
export default {
    name: 'PaymentProof'
}
</script>
