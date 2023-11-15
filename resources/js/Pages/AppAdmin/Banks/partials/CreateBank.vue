<script setup>
import { ref, reactive } from "vue";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/Custom/SelectInput.vue";
import Spinner from "@/Components/Custom/Spinner.vue";
import { BASE_URL } from "@/helpers/requestHelper.js";
import { userUserStore } from "@/stores/user";

const api = useAPI();
const $userStore = userUserStore();
let token = $userStore.getUserApp
    ? $userStore.getUserApp?.data?.auth_token
    : "";

const notification = useNotificationStore();

// Emits
const emit = defineEmits(['bankAdded'])

// Props:
const props = defineProps({
    countries: {
        type: Array,
        required: true
    }
})

// Form:
const formOpened = ref(false);

const openForm = () => {
    formOpened.value = true;
}

const endAdd = () => {
    formOpened.value = false;
    api.errors.value = {};
    resetBank();
}

const bank = reactive({
    'label': '',
    'country_id': null
})

const resetBank = () => {
    bank.label = ''
    bank.country_id = null
}

const addBank = async () => {
    console.log({ bank });
    api.startRequest();

    let payload = {
        ...bank,
        country_id: Number(bank?.country_id)

    }

    try {
        const res = await axios.post(`${BASE_URL}/banks`, payload, {
            headers: { Authorization: `Bearer ${token}` },
        })

        console.log({ res });
        if (res.data?.data?.id || res.data.status === "CREATED") {
            notification.notify('Bank added', 'success');
            endAdd();
            emit('bankAdded', res?.data?.data);
            formOpened.value = false;
        }
    } catch (errors) {
        console.log({ errors });
        notification.notify('Error', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
}

</script>

<template>
    <div>
        <button @click="openForm" type="button"
            class="mb-8 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Add new bank
        </button>


        <form v-show="formOpened" class="border-gray-400 border rounded-lg p-6 mb-8">
            <div class="grid gap-6 mb-10 md:grid-cols-2">
                <TextInput v-model="bank.label" :errors="api.errors.value?.label" label="Bank"
                    placeholder="Royal Bank Canada" required title="label" />
                <SelectInput v-model="bank.country_id" :errors="api.errors.value?.country_id" :options="countries?.data"
                    label="Choose a Country" required placeholder=" Country " title="country_id" type="text"
                    value-accessor="id" />
            </div>

            <div class="flex gap-4 items-center">
                <button @click="addBank" type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Add
                </button>
                <button type="button" @click="endAdd"
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
    name: "CreateBank"
}
</script>
