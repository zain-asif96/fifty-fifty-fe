<script setup>

import Spinner from "@/Components/Custom/Spinner.vue";

const props = defineProps({
    isLoading: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['file-changed'])

const fileChanged = (e) => {
    emit('file-changed', e.target.files[0])
}

</script>

<template>
    <div class="flex items-center justify-center w-full max-w-2xl relative">
        <input
            id="file_input"
            class="block w-full border border-gray-400 p-2 rounded-md text-lg text-gray-900 cursor-pointer
             bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700"
            type="file"
            @change="fileChanged"
        >

        <Spinner v-if="isLoading" class="absolute right-5"/>
    </div>
</template>

<script>
export default {
    name: "FileInput"
}
</script>
