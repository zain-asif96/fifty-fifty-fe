<script>
export default {
    name: 'ActionButton'
}
</script>

<script setup>

import Spinner from "@/Components/Custom/Spinner.vue";

defineProps({
    url: {
        default: '#'
    },
    isLoading: {
        type: Boolean,
        default: false
    },
    type: {
        default: 'button'
    }
})

</script>

<template>
    <button
        class="w-full md:w-96 relative rounded-lg bg-indigo-600 px-6 py-2.5 text-xl font-semibold leading-7 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        type="submit">

            <span :class="{'opacity-0': isLoading}">
                <slot/>
            </span>
        <Spinner v-if="isLoading" class="button-spinner-center action-btn"/>
    </button>
</template>
