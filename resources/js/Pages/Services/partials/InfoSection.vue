<script setup>

import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    text: String,
    title: String,
    image: String,
    direction: String,
})

</script>


<template>
    <div :class="{ 'reverse-section' : direction === 'reverse'}" class="services-info-section inside-container">
        <img
            :src="props.image"
            alt="dashboard image"
        >

        <div class="body-container">
            <FiftyText class="title" variation="heading-3">
                {{ props.title }}
            </FiftyText>

            <FiftyText class="body" variation="body-l">
                <p v-html="props.text"></p>
            </FiftyText>
        </div>

    </div>
</template>

<script>
export default {
    name: 'InfoSection'
}
</script>
