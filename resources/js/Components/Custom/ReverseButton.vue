<script>
export default {
    name: 'ReverseButton'
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
        default: 'link'
    }
})

</script>

<template>
    <div>
        <button
            class="w-full md:w-96 relative rounded-lg bg-white text-indigo-600 px-6 py-2.5 text-xl font-semibold leading-7 shadow-lg hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-800"
            type="submit">

            <span :class="{'opacity-0': isLoading}">
                <slot/>
            </span>
            <Spinner v-if="isLoading" class="button-spinner-center"/>
        </button>
    </div>
</template>
