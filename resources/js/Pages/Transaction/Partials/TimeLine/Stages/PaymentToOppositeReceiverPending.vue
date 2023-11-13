<script setup>
import {currencies_countries} from "@/helpers/currencies_countries";
import FullReceiverItem from "@/Pages/Transaction/Partials/FullReceiverItem.vue";
import UploadPaymentProof from "@/Pages/Transaction/Partials/UploadPaymentProof.vue";
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    transaction: {
        type: Object,
        required: true
    },
    isHidden: {
        type: Boolean,
        default: false
    }
})


const proofUploaded = (transaction) => {

}

</script>


<template>
    <li :class="{'opacity-30': isHidden}">
        <div class="track-step-icon w-3 h-3 mt-1.5 -left-1.5 border border-white"></div>

        <FiftyText class="mb-2">
            {{ transaction.payment_to_receiver_confirmed_at }}
        </FiftyText>

        <FiftyText variation="body-xl" color="dark" v-if="transaction.opposite_transaction">
            Please send
            <b class="uppercase">{{
                    parseFloat((transaction.opposite_transaction?.payment_intent.amount_in_receiver_currency / 100).toFixed(2))
                }} ({{ currencies_countries[transaction.opposite_transaction?.receiver.country] }}) </b>

            to <b> {{ transaction.opposite_transaction?.receiver.first_name }}
            {{ transaction.opposite_transaction?.receiver.last_name }}</b> :
        </FiftyText>

        <FullReceiverItem
            v-if="transaction.opposite_transaction"
            :receiver="transaction.opposite_transaction?.receiver"
        />

        <FiftyText>
            To release the hold on your card and get refund, please complete the payment and upload the proof
        </FiftyText>

        <UploadPaymentProof
            v-if="!isHidden"
            :transaction="transaction"
            url="/upload-payment-proof-direct"
            @uploaded="proofUploaded"
        />
    </li>

</template>

<script>
export default {
    name: "PaymentToOppositeReceiverPending"
}
</script>
