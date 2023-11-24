<script setup>
import Spinner from "@/Components/Custom/Spinner.vue";

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    url: {
        type: String,
        default: 'javascript:void(0)'
    },
    reversed: {
        type: Boolean,
        default: false
    },
    isLoading: {

    }
})

</script>

<template>
    <a :href="props.url" class="action-button" :class="{'reversed' : reversed}">
        <span :class="{'opacity-0': isLoading}">
                {{ props.title }}
        </span>

        <Spinner v-if="isLoading" class="button-spinner-center"/>
    </a>
</template>

<script>
export default {
    name: "NewActionButton"
}
</script>

<style lang="scss" scoped>

.action-button {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;

    background: #233375;
    color: white;

    font-family: 'Inter', serif;
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    border-radius: 8px;
    padding: 11px 46px;
    letter-spacing: 0.3px;
    border: 1px solid #233375;
    white-space: nowrap;
    transition: all 0.3s ease-in-out;

    &:hover {
        background: white;
        color: #233375;
        border: 1px solid #233375;
    }

    &.reversed{
        background: white;
        color: #233375;

        &:hover {
            background: #233375;
            color: white;
            border: 1px solid #233375;
        }
    }
}

</style>
