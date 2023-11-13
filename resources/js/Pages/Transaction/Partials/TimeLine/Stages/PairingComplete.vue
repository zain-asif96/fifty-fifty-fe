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
            {{ transaction.payment_to_receiver_completed_at }}
        </FiftyText>

        <FiftyText variation="body-xl" color="dark">
            Pairing is complete
        </FiftyText>

        <FiftyText>
            <slot/>
        </FiftyText>
    </li>
</template>

<script>
export default {
    name: "PairingComplete"
}
</script>
