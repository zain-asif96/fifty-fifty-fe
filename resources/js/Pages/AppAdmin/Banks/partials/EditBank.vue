<script setup>
import {useAPI} from "@/Composables/useAPI";
import {useNotificationStore} from "@/stores/notification";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/Custom/SelectInput.vue";
import Spinner from "@/Components/Custom/Spinner.vue";
import {onMounted, reactive} from "vue";

const api = useAPI();
const notification = useNotificationStore();

// Emits
const emit = defineEmits(['bankEdited', 'endEdit'])

// Props:
const props = defineProps({
    countries: {
        type: Array,
        required: true
    },
    editedBank: {
        type: Object,
        required: true
    }
})

const endEdit = () => {
    api.errors.value = {};
    emit('endEdit');
}

const updateBank = async () => {
    api.startRequest();

    try {
        const res = await axios.put('/admin/banks/update/' + props.editedBank.value.id, localBank)

        if (res.data) {
            notification.notify('Bank updated', 'success');
            endEdit();
            emit('bankEdited', localBank);
        }
    } catch (errors) {
        notification.notify('Error', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
}

const localBank = reactive({});

onMounted(() => {
    localBank.id = props.editedBank.value.id;
    localBank.country = props.editedBank.value.country;
    localBank.label = props.editedBank.value.label;
    localBank.country_id = props.editedBank.value.country_id;
})

</script>

<template>
    <div >
        <form class="border-gray-400 border rounded-lg p-6 mb-8">
            <div class="grid gap-6 mb-10 md:grid-cols-2">
                <TextInput
                    v-model="localBank.label"
                    :errors="api.errors.value?.label"
                    label="Bank"
                    placeholder="Royal Bank Canada"
                    required
                    title="label"
                />
                <SelectInput
                    v-model="localBank.country_id"
                    :errors="api.errors.value?.country_id"
                    :options="countries"
                    label="Choose a Country"
                    required
                    placeholder=" Country "
                    title="country_id"
                    type="text"
                    value-accessor="id"
                />
            </div>

            <div class="flex gap-4 items-center">
                <button
                    @click="updateBank"
                    type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Update
                </button>
                <button
                    type="button"
                    @click="endEdit"
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
    name: "EditBank"
}
</script>
