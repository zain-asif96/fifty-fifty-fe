<script setup>
import { computed } from 'vue';
import FiftyText from "@/Components/Design/FiftyText.vue";
import { ref } from 'vue';

// const emit = defineEmits(['update:modelValue']);
defineEmits(['update:modelValue']);

const props = defineProps({
    'modelValue': {
        required: true,
        type:String,
        default: 'bank',

    },
    options: {
        type: Array,
        required: true,
    },
    title: {
        type: String,
        // required: true
    },
    'label': {
        default: '',
        type: String
    },
    required: {
        type: Boolean,
        default: false
    },
    customStyle: {
        type:Object,
        default:'',
    }, // This prop will accept a style object

});

const selectedOption = ref(props.options[0].value);
const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <div class="w-full flex flex-col justify-start relative fifty-form-input" :style="customStyle">
        <!-- <input type="radio" id="css" name="fav_language" value="CSS"> -->
        <!-- <input type="radio" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"> -->
        <label :for="title" class="w-fit inline-block mb-2">
            <FiftyText>
                {{ label ?? '' }} <span v-if="required" class="text-red-600">*</span>
            </FiftyText>
        </label>
        <div>
            <label v-for="option in options" :key="option.value">
                <input type="radio" :value="option.value" v-model="selectedOption"
                    @input="$emit('update:modelValue', $event.target.value)" />
                {{ option.label }}
            </label>
            <!-- <p>Selected option: {{ selectedOption }}</p> -->
        </div>

    </div>
</template>
<style scoped>
label{
    margin:10px
}
[type='checkbox'], [type='radio']{
    color:#233375
}
[type='checkbox']:focus, [type='radio']:focus{
    --tw-ring-color: #233375;
}</style>
