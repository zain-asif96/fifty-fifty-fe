<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";
import {useHelpers} from "@/Composables/useHelpers";

const props = defineProps({
    transaction: {
        type: Object,
        required: true
    },
    text: {
        type: String,
        default: 'A corresponding post has been published to our users in',
        required: false
    }
})

const helpers = useHelpers()

</script>


<template>
    <li>
        <div class="track-step-icon w-3 h-3 mt-1.5 -left-1.5 border border-white"></div>

        <FiftyText class="mb-2">
            {{ new Date(Number(transaction.pairing_pending_time)).toISOString() }}
            
        </FiftyText>

        <FiftyText class="transaction-heading" variation="body-xl" color="dark">
            {{ transaction.pairing_pending_title }}
        </FiftyText>

        <FiftyText>
            {{ transaction.pairing_pending_message }}
        </FiftyText>
    </li>
</template>

<script>
export default {
    name: "PairingPending"
}
</script>
