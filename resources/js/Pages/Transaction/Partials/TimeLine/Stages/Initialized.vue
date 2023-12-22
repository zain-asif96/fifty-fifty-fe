<script setup>

import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    transaction: {
        type: Object,
        required: true
    },
    text: {
        type: String,
        default: 'Your card has been successfully authorized and your transaction has been successfully initialized',
        required: false
    }
})

</script>


<template>
    <li>
        <div class="track-step-icon w-3 h-3 mt-1.5 -left-1.5 border border-white"></div>

        <FiftyText class="mb-2">
            {{ new Date(Number(transaction.initialize_time)).toISOString() }}
            
        </FiftyText>

        <FiftyText class="transaction-heading" variation="body-xl" color="dark">
            {{ transaction.initialize_title }}
        </FiftyText>

        <FiftyText>
            {{ transaction.initialize_message }}
        </FiftyText>
    </li>
</template>

<script>
export default {
    name: "Initialized"
}
</script>
