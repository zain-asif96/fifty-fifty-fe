<script setup>
import {onMounted, ref} from 'vue';

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
    },
    'selected':{
        type: String,
        default: null,
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
    <div class="w-full md:w-96 flex flex-col justify-start relative">
        <label class="w-fit form-label inline-block mb-2 text-lg text-gray-700" for="exampleFormControlInput1">
            {{ label ?? '' }} <span v-if="required" class="text-red-600">*</span>
        </label>
        <select
            id="exampleFormControlInput1"
            ref="input"
            :class="{'border-red-300': errors.length > 0, 'bg-gray-300': disabled}"
            :disabled="disabled"
            :value="modelValue"
            class="form-control block w-full px-3 py-1.5 text-lg font-normal
                  text-gray-700  bg-clip-padding border border-solid border-gray-300 rounded transition
                  ease-linear m-0
                  focus:text-gray-700 focus:bg-white focus:border-indigo-300 focus:outline-none"
            @change="$emit('update:modelValue', $event.target.value)"
        >
            <option class="bg-gray-200" disabled value="">--{{ placeholder }}--</option>
            <option v-for="option in options" :key="option[valueAccessor]" :value="option[valueAccessor]" :selected="option[valueAccessor]==selected?'selected':''">
                {{ option[labelAccessor] }}
            </option>
        </select>
        <div class="text-red-600 text-base absolute left-0 -bottom-7 whitespace-nowrap">
            {{ errors[0] }}
        </div>
    </div>
</template>
<script>
export default {
    name: "SelectInput"
}
</script>
