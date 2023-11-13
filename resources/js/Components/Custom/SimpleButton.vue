<script setup>
import Spinner from "@/Components/Custom/Spinner.vue";

defineProps({
    isLoading: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <a class="relative mt-4 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4
     focus:outline-none focus:ring-gray-200 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700 hover:cursor-pointer"
    >
        <span :class="{'opacity-0': isLoading}">
                <slot/>
            </span>
        <Spinner v-if="isLoading" class="button-spinner-center"/>
    </a>
</template>

<script>
export default {
    name: "SimpleButton"
}
</script>
