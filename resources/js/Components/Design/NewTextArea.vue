<script setup>
import {onMounted, ref} from 'vue';
import FiftyText from "@/Components/Design/FiftyText.vue";
import Spinner from "@/Components/Custom/Spinner.vue";

defineProps({
    modelValue: {
        required: true
    },
    label: {
        default: '',
        type: String
    },
    placeholder: {
        default: '',
        type: String
    },
    type: {
        default: 'text'
    },
    max: {
        default: 10000
    },
    min: {
        default: 10
    },
    required: {
        type: Boolean,
        default: false
    },
    disabled: {
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
    info: {
        type: String,
        required: false
    },
    isLoading: {
        type: Boolean,
        default: false
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <div class="w-full flex flex-col justify-start relative">
        <label :for="title" class="w-fit inline-block mb-2">
            <FiftyText>
                {{ label ?? '' }} <span v-if="required" class="text-red-600">*</span>
            </FiftyText>
        </label>
        <textarea
            :id="title"
            ref="input"
            rows="3"
            :class="{'border-red-300': errors.length > 0, 'bg-gray-300': disabled}"
            :disabled="disabled"
            :placeholder="placeholder"
            :value="modelValue"
            class="form-control block w-full text-lg font-normal
                  text-gray-700 bg-clip-padding border border-solid transition
                  ease-linear m-0
                  focus:text-gray-700 focus:bg-white focus:border-indigo-300 focus:outline-none"
            @input="$emit('update:modelValue', $event.target.value)"
        ></textarea>
        <div class="flex justify-between">
            <div class="text-red-600 text-base whitespace-nowrap">
                {{ errors[0] }}
            </div>

            <div class="text-gray-500 text-base font-semibold absolute right-2 top-11 whitespace-nowrap">
                {{ info }}
            </div>
        </div>

        <Spinner v-if="isLoading" class="right-1 top-0 absolute"/>
    </div>
</template>

<script>
export default {
    name: "NewTextArea"
}
</script>


<style lang="scss">
.form-control {
    height: auto;
    border: 1px solid #D9D9E0;
    border-radius: 8px;
    min-width: 250px;
}
</style>
