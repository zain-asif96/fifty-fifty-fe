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
            {{ transaction.created_at }}
        </FiftyText>

        <FiftyText variation="body-xl" color="dark">
            Transaction successfully initialized
        </FiftyText>

        <FiftyText>
            <slot/>
        </FiftyText>
    </li>
</template>

<script>
export default {
    name: "Initialized"
}
</script>
