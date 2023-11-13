<script setup>
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

</script>


<template>
    <li :class="{'opacity-30' : isHidden}">
        <div class="track-step-icon w-3 h-3 mt-1.5 -left-1.5 border border-white"></div>

        <FiftyText class="mb-2">
            {{ transaction.payment_to_opposite_receiver_confirmed_at }}
        </FiftyText>

        <FiftyText variation="body-xl" color="dark">
            Your payment has been confirmed!
        </FiftyText>

        <FiftyText v-if="transaction.opposite_transaction">
            <b>
                {{ transaction.opposite_transaction.receiver.first_name }}
                {{ transaction.opposite_transaction.receiver.last_name }}
            </b>
            has received money! Refund has been released to your card.
        </FiftyText>
    </li>
</template>

<script>
export default {
    name: "PaymentToOppositeReceiverConfirmed"
}
</script>
