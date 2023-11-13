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
    <li :class="{'opacity-30': isHidden}" class="mb-10 ml-4">
        <div class="track-step-icon w-3 h-3 mt-1.5 -left-1.5 border border-white"></div>

        <FiftyText class="mb-2">
            {{ transaction.transaction_completed_at }}
        </FiftyText>

        <FiftyText variation="body-xl" color="dark">
            Thank for using 50-50!
        </FiftyText>
    </li>
</template>

<script>
export default {
    name: "TransactionCompleted"
}
</script>
