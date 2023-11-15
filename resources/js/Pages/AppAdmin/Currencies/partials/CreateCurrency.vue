<script setup>
import {ref, reactive} from "vue";
import {useAPI} from "@/Composables/useAPI";
import {useNotificationStore} from "@/stores/notification";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/Custom/SelectInput.vue";
import Spinner from "@/Components/Custom/Spinner.vue";

const api = useAPI();
const notification = useNotificationStore();

// Emits
const emit = defineEmits(['currencyAdded']);

// Form:
const formOpened = ref(false);

const openForm = () => {
    formOpened.value = true;
}

const endAdd = () => {
    formOpened.value = false;
    api.errors.value = {};
    resetCurrency();
}

const currency = reactive({
    'name': '',
    'rate': '',
    'special_rate': '',
    'rate_source': '',
    'code': '',
})


const sourceOptions = [
    {
        label: 'World Bank',
        value: 'world_bank'
    },
    {
        label: 'Special Rate',
        value: 'special'
    }
];


const resetCurrency = () => {
    currency.code = ''
    currency.rate = ''
    currency.special_rate = ''
    currency.name = ''
    currency.rate_source = ''
}

const addCurrency = async () => {
    api.startRequest();

    try {
        const res = await axios.post('/admin/currencies/store', currency)

        if (res.data.id || res.data.status === 'success') {
            notification.notify('Currency added', 'success');
            endAdd();
            emit('currencyAdded');
        }
    } catch (errors) {
        notification.notify('Error', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
}

</script>

<template>
    <div >
        <button @click="openForm" type="button" class="mb-8 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Add new currency
        </button>


        <form v-show="formOpened" class="border-gray-400 border rounded-lg p-6 mb-8">
            <div class="grid gap-6 mb-10 md:grid-cols-2">
                <TextInput
                    v-model="currency.code"
                    :errors="api.errors.value?.code"
                    label="Currency code"
                    placeholder="USD"
                    required
                    title="code"
                />

                <TextInput
                    v-model="currency.name"
                    :errors="api.errors.value?.name"
                    label="Currency Name"
                    placeholder="American Dollar"
                    required
                    title="name"
                />

                <TextInput
                    v-model="currency.rate"
                    :errors="api.errors.value?.rate"
                    label="Rate"
                    placeholder="Rate"
                    required
                    type="number"
                    title="name"
                />

                <TextInput
                    v-model="currency.special_rate"
                    :errors="api.errors.value?.special_rate"
                    label="Special Rate"
                    placeholder="Special Rate"
                    required
                    type="number"
                    title="special_rate"
                />

                <SelectInput
                    v-model="currency.rate_source"
                    :errors="api.errors.value?.rate_source"
                    :options="sourceOptions"
                    label="Rate Source"
                    required
                    placeholder=" Select "
                    title="currency"
                    type="text"
                />
            </div>

            <div class="flex gap-4 items-center">
                <button
                    @click="addCurrency"
                    type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Add
                </button>
                <button
                    type="button"
                    @click="endAdd"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Cancel
                </button>

                <Spinner v-if="api.isLoading.value" class="button-spinner-center action-btn"/>
            </div>

        </form>

    </div>
</template>

<script>
export default {
    name: "CreateCurrency"
}
</script>
