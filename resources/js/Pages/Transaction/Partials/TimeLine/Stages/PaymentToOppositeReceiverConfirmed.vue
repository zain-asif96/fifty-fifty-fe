<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";
import { useHelpers } from "@/Composables/useHelpers";

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

const helpers = useHelpers()


</script>


<template>
    <li :class="{'opacity-30' : isHidden}">
        <div class="track-step-icon w-3 h-3 mt-1.5 -left-1.5 border border-white"></div>

        <FiftyText class="mb-2">
            {{ helpers.getDateFormat(Number(transaction.send_payment_time)) }}
            
            
        </FiftyText>

        <FiftyText class="transaction-heading" variation="body-xl" color="dark">
            {{ transaction.send_payment_title }}
        </FiftyText>

        <FiftyText>
            {{ transaction.send_payment_message }}
        </FiftyText>
    </li>
</template>

<script>
export default {
    name: "PaymentToOppositeReceiverConfirmed"
}
</script>
