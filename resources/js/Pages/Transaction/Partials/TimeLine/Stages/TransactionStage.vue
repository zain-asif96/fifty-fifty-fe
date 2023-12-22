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
    },

})

</script>


<template>
    <li :class="{'opacity-30': isHidden}" >
        <div class="track-step-icon w-3 h-3 mt-1.5 -left-1.5 border border-white"></div>

        <FiftyText class="mb-2">
            {{ new Date(Number(transaction.payment_confirmed_time)).toISOString() }}
            
        </FiftyText>

        <FiftyText class="transaction-heading" variation="body-xl" color="dark">
            {{ transaction.payment_confirmed_title }}
        </FiftyText>

        <FiftyText>
            {{ transaction.payment_confirmed_message }}
        </FiftyText>
    </li>
</template>

<script>
export default {
    name: "TransactionStage"
}
</script>
