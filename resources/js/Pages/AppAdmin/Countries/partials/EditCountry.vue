<script setup>
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/Custom/SelectInput.vue";
import Spinner from "@/Components/Custom/Spinner.vue";
import { onMounted, reactive, watch } from "vue";
import { BASE_URL } from "@/helpers/requestHelper";
import { userUserStore } from "@/stores/user";

const api = useAPI();
const $userStore = userUserStore();
let token = $userStore.getUserApp
    ? $userStore.getUserApp?.data?.auth_token
    : "";
const notification = useNotificationStore();

// Emits
const emit = defineEmits(['countryEdited', 'endEdit'])

// Props:
const props = defineProps({
    currencies: {
        type: Array,
        required: true
    },
    editedCountry: {
        type: Object,
        required: true
    }
})

const endEdit = () => {
    api.errors.value = {};
    emit('endEdit');
}

const updateCountry = async () => {
    api.startRequest();

    console.log({ localCountry });
    let payload = {
        ...localCountry,
        status: localCountry?.status === true ? 'Active' : 'Inactive',
        currency_id: Number(localCountry.id)
    }
    delete payload.id
    delete payload.currency

    try {
        const res = await axios.put(BASE_URL + '/countries/' + props.editedCountry.value.id, payload, {
            headers: { Authorization: `Bearer ${token}` },
        })

        if (res.data?.data) {
            console.log({ res });

            notification.notify('Country updated', 'success');
            endEdit();
            let editTemp = { ...res.data?.data, currency: props?.currencies.data?.find((dt) => dt?.id == localCountry?.id) }
            console.log({ editTemp });
            emit('countryEdited', editTemp);
        }
    } catch (errors) {
        console.log({ errors });
        notification.notify('Error', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
}

const sendOptions = [
    {
        label: 'Yes',
        value: 'Y'
    },
    {
        label: 'No',
        value: 'N'
    }
];

const localCountry = reactive({});

onMounted(() => {
    // localCountry.id = props.editedCountry.value.id;
    localCountry.label = props.editedCountry.value.label;
    localCountry.code = props.editedCountry.value.code;
    localCountry.code_iso_2 = props.editedCountry.value.code_iso_2;
    localCountry.can_send = props.editedCountry.value.can_send;
    localCountry.can_receive = props.editedCountry.value.can_receive;
    localCountry.id = props.editedCountry.value.currency_id;
    localCountry.currency = props.editedCountry.value.currency;
    // when the status column is added chencge this one
    localCountry.status = props.editedCountry.value.status && props.editedCountry.value.status?.toLowerCase() == 'active' ? true : false;
})
watch(props.editedCountry, () => {
    localCountry.label = props.editedCountry.value.label;
    localCountry.code = props.editedCountry.value.code;
    localCountry.code_iso_2 = props.editedCountry.value.code_iso_2;
    localCountry.can_send = props.editedCountry.value.can_send;
    localCountry.can_receive = props.editedCountry.value.can_receive;
    localCountry.id = props.editedCountry.value.currency_id;
    localCountry.currency = props.editedCountry.value.currency;
    // when the status column is added chencge this one
    localCountry.status = props.editedCountry.value.status && props.editedCountry.value.status?.toLowerCase() == 'active' ? true : false;

})

</script>

<template>
    <div>
        <form class="border-gray-400 border rounded-lg p-6 mb-8">
            <div class="grid gap-6 mb-10 md:grid-cols-2">
                <TextInput v-model="localCountry.label" :errors="api.errors.value?.label" label="Country Name"
                    placeholder="United States of America" required title="label" />

                <TextInput v-model="localCountry.code" :errors="api.errors.value?.code" label="Code ISO 3" placeholder="USA"
                    required title="code" />

                <TextInput v-model="localCountry.code_iso_2" :errors="api.errors.value?.code_iso_2" label="Code ISO 2"
                    placeholder="US" required title="code_iso_2" />

                <SelectInput v-model="localCountry.can_send" :errors="api.errors.value?.can_send" :options="sendOptions"
                    label="Can send" required placeholder=" Select " title="can_send" type="text" />

                <SelectInput v-model="localCountry.can_receive" :errors="api.errors.value?.can_receive"
                    :options="sendOptions" label="Can receive" required placeholder=" Select " title="can_receive"
                    type="text" />

                <SelectInput v-model="localCountry.id" :errors="api.errors.value?.id" :options="currencies.data"
                    label="Currency" required placeholder=" Select " title="currency_id" type="text" value-accessor="id"
                    label-accessor="name" />
                <div class="w-full md:w-96 flex  justify-start relative">
                    <label>Status</label>
                    <input type="checkbox" :class="localCountry.status ? 'slider-checked' : ''" class="slider"
                        v-model="localCountry.status" />
                </div>

            </div>

            <div class="flex gap-4 items-center">
                <button @click="updateCountry" type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Update
                </button>
                <button type="button" @click="endEdit"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Cancel
                </button>

                <Spinner v-if="api.isLoading.value" class="button-spinner-center action-btn" />
            </div>

        </form>

    </div>
</template>

<script>
export default {
    name: "EditCountry"
}
</script>
<style scoped>
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
