<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    number: String,
    title: String,
    description: String
})
</script>

<template>
    <div class="working-step">
        <div class="step-number">
            {{ number }}
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
    name: "WorkingStep"
}
</script>

<style lang="scss" scoped>
.working-step {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    text-align: left;
    gap: 12px;
    padding: 24px;
    max-width: 300px;
    border: 2px solid #F8F9FE;
    border-radius: 16px;
    flex: 1;


    @media (max-width: 1065px) {
        flex: auto;
        max-width: 50%;
    }

    @media (max-width: 933px) {
        max-width: 100%;
    }

    .step-number {
        font-family: 'General Sans', serif;
        font-style: normal;
        font-weight: 600;
        font-size: 28px;
        line-height: 140%;
        color: #04A949;
        margin-bottom: 18px;
    }
}
</style>
