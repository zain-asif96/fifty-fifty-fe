<script setup>
const props = defineProps({
    color: {
        type: String,
        default: 'currentColor'
    }
})
</script>

<template>
    <svg :fill="color" aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" viewBox="0 0 20 20"
         xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd"
              d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
              fill-rule="evenodd"></path>
    </svg>
</template>

<script>
export default {
    name: 'ArrowRight'
}
</script>

