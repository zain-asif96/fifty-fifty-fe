<script setup>
import { ref, reactive } from "vue";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";
import TextInput from "@/Components/TextInput.vue";
// import SelectInput from "@/Components/Custom/SelectInput.vue";
import Spinner from "@/Components/Custom/Spinner.vue";
import Modal from "@/Components/Custom/Modal.vue";

const notification = useNotificationStore();
const api = useAPI();

// Props:
const props = defineProps({
    currencyData: {
        type: Object,
        required: true
    },
    show: {
        type: Boolean,
        default: false
    }
})
const isModalOpened = ref(props.show);
console.log('modal here', isModalOpened.value);
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
    console.log('this s iedit', isFetchData);
    emit("close", isFetchData);
}
const applyEdit = async () => {
    api.startRequest();
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // Set the CSRF token as a default header for all Axios requests
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    try {
        const res = await axios.put('/admin/currencies/update/' + props.currencyData.value.id, props.currencyData.value)
        if (res.data) {
            console.log('res', res);
            let data = props.currencyData.value
            console.log('data', data);

            notification.notify('Currency updated', 'success');
            endEdit();
            close(props.currencyData.value);
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
    // currencyData.value = {};
}
</script>

<template>
    <div>
        <Modal :close="close" :isOpen="isModalOpened" header="Edit Currency">
            <template #content>
                <form class="  p-2 mb-2" @submit.prevent="submit">
                    <div class="flex flex-wrap gap-2 mb-3 justify-content-center">
                        <!-- <input type="number" class="w-20 text-black" v-model=""> -->
                        <TextInput v-model="currencyData.value.code" label="Currency Code" placeholder="Currency Code"
                            required title="code" />
                        <TextInput v-model="currencyData.value.name" label="Currency Name" placeholder="Currency Name"
                            required title="name" />

                        <TextInput v-model="currencyData.value.rate" label="Currency Rate" placeholder="Currency Rate"
                            required title="code" />

                        <TextInput v-model="currencyData.value.special_rate" label="Special Rate" placeholder="Special Rate"
                            required title="special_rate" />
                        <div>
                            <label for="">Rate Source</label>
                            <select name="rate_source" class="w-full md:w-96 flex flex-col justify-start relative"
                                id="rate_source" v-model="currencyData.value.rate_source">
                                <option value="world_bank">World Bank</option>
                                <option value="special">Special Rate</option>
                            </select>
                        </div>

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

                        <Spinner v-if="api.isLoading.value" class="button-spinner-center action-btn" />
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
</style>
