<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    date: {
        type: String,
        required: true
    },
    title: {
        type: String,
        required: true
    },
    text: {
        type: String,
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
            {{ date }}
        </FiftyText>

        <FiftyText variation="body-xl" color="dark">
            {{ title }}
        </FiftyText>

        <FiftyText>
            {{ text }}

            <slot/>
        </FiftyText>
    </li>
</template>

<script>
export default {
    name: "TransactionStage"
}
</script>
