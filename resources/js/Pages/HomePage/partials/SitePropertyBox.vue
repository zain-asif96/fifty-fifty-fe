<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    iconSrc: {
        type: String,
        required: true
    },
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    }
})

</script>

<template>
    <div class="site-property">
        <div class="icon">
            <img :src="iconSrc" alt="Icon">
        </div>

        <FiftyText color="dark" variation="body-l">
            {{ title }}
        </FiftyText>

        <FiftyText>
            {{ description }}
        </FiftyText>
    </div>
</template>

<script>
export default {
    name: "SitePropertyBox"
}
</script>

<style lang="scss" scoped>
.site-property {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 18px;
    padding: 24px;
    background: #FFFFFF;
    border-radius: 16px;
    max-width: 335px;
}
</style>
