<script setup>
import { ref, reactive,computed } from "vue";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";
import Modal from "@/Components/Custom/Modal.vue";
import TextInput from "@/Components/TextInput.vue";

const notification = useNotificationStore();
const api = useAPI();
// Props:
const props = defineProps({
    timeData: {
        type: Object,
        required: true
    },
    show: {
        type: Boolean,
        default: false
    },
})
const time = reactive({
    // 'model_name': 'App\\Models\\Post',
    'time': props.timeData.time,
})
const isModalOpened = ref(props.show);
// const closeModal = () => {
//     isModalOpened.value = false;
// }
const openModal = () => {
    console.log('inside openModal ');
    if (props.show) return;
    isModalOpened.value = true;
}


// Emits
const emit = defineEmits(['close'])

function close(isFetchData) {
    console.log('this s iedit',isFetchData)
    ;
    emit("close", isFetchData);
}
const applyEdit = async () => {
    api.startRequest();
    console.log('timeData', props.timeData.value.id, time);
    // const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // // Set the CSRF token as a default header for all Axios requests
    // axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    // console.log('csrfToken', csrfToken);
    try {
        // const res = await axios.put('/admin/currencies/update/' + props.currencyData.value.id, props.currencyData.value)
        const res = await axios.put('/admin/update-status-time/' +props.timeData.value.id, time)

        if (res.data) {
            notification.notify('Time updated', 'success');
            // endEdit();
            close(time);
        }
    } catch (errors) {
        console.log('errors', errors);
        // notification.notify('Error', 'error');
        // api.handleErrors(errors)
    } finally {
        // api.requestCompleted();
    }
}

const endEdit = () => {
    api.errors.value = {};
    timeData.value = {};
}
</script>

<template>
    <div>
        <Modal :close="close" :isOpen="isModalOpened" header="Edit Time">
            <template #content>
                <form class="  p-2 mb-2" @submit.prevent="submit">
                    <div class="flex flex-wrap gap-2 mb-3 justify-content-center">
                        <TextInput v-model="time.time" label="Time (min)" placeholder="Time (min)"
                            required title="code" />
                    </div>

                    <div class="flex gap-4 items-center">
                        <button type="submit" @click="applyEdit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Edit
                        </button>
                        <button type="button" @click="close"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Cancel
                        </button>

                        <!-- <Spinner v-if="api.isLoading.value" class="button-spinner-center action-btn" /> -->
                    </div>

                </form>
            </template>

        </Modal>




    </div>
</template>

<style scoped>
select#rate_source {
    height: fit-content;
    border-color: #d9d9d9 !important;
}

.flex.flex-wrap.gap-2.mb-3.justify-content-center {
    justify-content: center;
}
.slider {
    /* -webkit-appearance: none; */
    width: 40px;
    height: 20px;
    border-radius: 20px;
    background: #c6c6c6;
    outline: none;
    opacity: 0.7;
    transition: .2s;
    margin: 0 10px;
}

.slider:hover {
    opacity: 1;
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #4CAF50;
    cursor: pointer;
}

.slider::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #4CAF50;
    cursor: pointer;
}

.slider-checked {
    background-color: #1C64F2;
}
</style>
