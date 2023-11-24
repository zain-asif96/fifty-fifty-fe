<script setup>
import {onMounted, ref} from 'vue';
import FiftyText from "@/Components/Design/FiftyText.vue";

defineProps({
    'modelValue': {
        required: true
    },
    'label': {
        default: '',
        type: String
    },
    'placeholder': {
        default: '',
        type: String
    },
    type: {
        default: 'text'
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
    labelAccessor: {
        type: String,
        default: 'label',
    },
    valueAccessor: {
        type: String,
        default: 'value',
    },
    options: {
        type: Array,
        required: true
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
        <label :for="title" class="w-fit inline-block mb-2 font-inter text-xs text-custom-greyish">
            <FiftyText>
                {{ label ?? '' }} <span v-if="required" class="text-red-600">*</span>
            </FiftyText>
        </label>
        <select
            id="exampleFormControlInput1"
            ref="input"
            :class="{'border-red-300': errors.length > 0, 'bg-gray-300': disabled}"
            :disabled="disabled"
            :value="modelValue"
            class="form-control block w-full px-3 py-1.5 font-sans text-sm font-normal
                  text-greyish-700 bg-clip-padding border border-solid border-gray-300 rounded transition
                  ease-linear m-0
                  focus:text-gray-700 focus:bg-white focus:border-indigo-300 focus:outline-none"
            @change="$emit('update:modelValue', $event.target.value)"
        >
            <option class="bg-gray-200" disabled selected value="">--{{ placeholder }}--</option>
            <option v-for="option in options" :key="option[valueAccessor]" :value="option[valueAccessor]">
                {{ option[labelAccessor] }}
            </option>
        </select>
        <div class="text-red-600 text-base">
            {{ errors[0] }}
        </div>
    </div>
</template>
<script>
export default {
    name: "NewSelectInput"
}
</script>

<style lang="scss">
.form-control {
    height: 48px;
    border: 1px solid #D9D9E0;
    border-radius: 8px;
    min-width: 250px;
}
</style>
