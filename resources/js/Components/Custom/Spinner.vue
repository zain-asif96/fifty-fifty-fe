<script>
export default {
    name: 'Spinner'
}
</script>

<script setup>

defineProps({
    colorClass: {
        type: String,
        default: 'text-white'
    }
})

</script>

<style>
.spinner-border {
    vertical-align: -.125em;
    border: .20em solid darkgray;
    border-right-color: transparent;
}
</style>

<template>
    <div class="flex items-center justify-center">
        <div class="spinner-border border- animate-spin inline-block w-6 h-6 border-4 rounded-full"
             role="status"></div>
    </div>
</template>
