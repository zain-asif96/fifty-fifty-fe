<script setup>

import FiftyText from "@/Components/Design/FiftyText.vue";

defineProps({
    'label': {
        default: '',
        type: String
    },
    required: {
        type: Boolean,
        default: false
    },
    errors: {
        type: Object,
        default: {}
    },
    title: {
        type: String,
        required: true
    },
    hint: {
        default: '',
        type: String
    }
});


defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <div class="flex justify-center w-full">
        <div class="w-full flex flex-col justify-start relative">
            <label class="w-fit inline-block mb-2 flex items-center gap-2" for="exampleFormControlInput1">
                <FiftyText>
                    {{ label ?? '' }} <span v-if="required" class="text-red-600">*</span>
                </FiftyText>
                <span class="text-sm ml-2">{{ hint }}</span>
            </label>

            <slot/>

            <div class="text-red-600 text-base">
                {{ errors[0] }}
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "InternationalTelInput"
}
</script>
