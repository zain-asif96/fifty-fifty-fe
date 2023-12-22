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
    <li :class="{'opacity-30': isHidden}">
        <div class="track-step-icon w-3 h-3 mt-1.5 -left-1.5 border border-white"></div>

        <FiftyText class="mb-2">
            {{ new Date(Number(transaction.pairing_complete_time)).toISOString() }}
            
        </FiftyText>

        <FiftyText class="transaction-heading" variation="body-xl" color="dark">
            {{ transaction.pairing_complete_title }}
        </FiftyText>

        <FiftyText>
            {{ transaction.pairing_complete_message }}
        </FiftyText>
    </li>
</template>

<script>
export default {
    name: "PairingComplete"
}
</script>
