<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Custom/Pagination.vue";
import { Head } from '@inertiajs/vue3';
import CreateBank from "@/Pages/Admin/Banks/partials/CreateBank.vue";
import DeleteIcon from "@/Icons/DeleteIcon.vue";
import EditIcon from "@/Icons/EditIcon.vue";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";
import Spinner from "@/Components/Custom/Spinner.vue";
import { reactive, ref, onMounted } from "vue";
import EditBank from "@/Pages/Admin/Banks/partials/EditBank.vue";
import { router } from '@inertiajs/vue3'
import { useSortingStore } from "@/stores/sorting";
import TextInput from "@/Components/TextInput.vue";


const api = useAPI();
const notification = useNotificationStore();

const props = defineProps({
    banks: {
        required: true,
        type: Object
    },
    countries: {
        required: true,
        type: Array
    }
})

// Adding
const bankAdded = () => {
    props.banks.total++;
}

const editedBank = reactive({});

// Editing
const edit = (bank) => {
    editedBank.value = bank;
}
const endEdit = () => {
    editedBank.value = {}
}

const bankEdited = (bank) => {
    let index = props.banks.data.findIndex(oldInfo => oldInfo.id === bank.id);
    props.banks.data.splice(index, 1, bank);
}

// Deleting
const deletingBankId = ref(null);
const deleteBank = async (bank) => {
    deletingBankId.value = bank.id;

    api.startRequest();

    try {
        const res = await axios.delete('/admin/banks/delete/' + bank.id)

        if (res.data.id || res.data.status === 'success') {
            notification.notify('Bank deleted', 'success');
            bank.id = 'deleted';
            props.banks.total--;
        }
    } catch (errors) {
        notification.notify('Error', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
}

// Search

var currentPage = ref(1)

let searchValue = ref('');
const search = () => {
    router.visit(`?page=${currentPage.value}&q=${searchValue.value}&column=${store.column}&type=${store.type}`);
}

// sorting
var disableClick = ref(false)
const store = useSortingStore();
const sort = (column) => {
    searchValue.value = searchValue.value != null ? searchValue.value : ""
    disableClick.value = true
    store.sortValues(column);
    let res = router.visit(`?page=${currentPage.value}&q=${searchValue.value}&column=${store.column}&type=${store.type}`);
if (res) {
        disableClick.value = false
    }};
const clearSearch = () => {
    router.visit(`?q=`);
}
onMounted(() => {
    searchValue.value = new URLSearchParams(window.location.search).get('q');
    let cpg = new URLSearchParams(window.location.search).get('page');
    currentPage.value = cpg!=null?cpg:1
});
</script>

<template>
    <Head title="Banks">
        <title>
            Admin Panel | Banks
        </title>
    </Head>

    <AdminLayout>
        <div class="ml-4 md:ml-16">
            <div class="mt-16 mb-8 text-xl flex items-center justify-between">
                <div>
                    Banks
                </div>
                <div class="text-sm">
                    Page: {{ props.banks.current_page }}
                    | total: {{ props.banks.total }}
                    | from: {{ props.banks.from }},
                    to: {{ props.banks.to }}
                </div>
            </div>


            <CreateBank @bankAdded="bankAdded" :countries="countries" />

            <EditBank v-if="editedBank.value?.id" @endEdit="endEdit" @bankEdited="bankEdited" :edited-bank="editedBank"
                :countries="countries" />
            <div class="flex items-end gap-3 ">
                <TextInput v-model="searchValue" class="mb-8" label="Search" placeholder="Search" title="searchValue"
                    v-on:keyup.enter="search" />

                <button @click="search" type="button"
                    class="mb-8 flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Search
                </button>

                <button v-if="searchValue" @click="clearSearch" type="button"
                    class="mb-8 flex items-center text-blue-700 bg-white border border-blue-700 hover:bg-gray-100 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Clear
                </button>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col" @click="sort('id')">
                                #ID <span class="fw-100">{{ store.column == 'id' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col" @click="sort('label')">
                                Bank Name <span class="fw-100">{{ store.column == 'label' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col" @click="sort('country')">
                                Country <span class="fw-100">{{ store.column == 'country' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="bank in props.banks.data" :key="bank.id" v-show="bank.id !== 'deleted'"
                            class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">

                            <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" scope="row">
                                {{ bank.id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ bank.label }}
                            </td>
                            <td class="px-6 py-4">
                                {{ bank.country ? bank.country.label : 'N/A' }} ({{ bank.country ? bank.country.code : 'N/A'
                                }})
                            </td>
                            <td class="px-6 py-4 flex gap-4 items-center">
                                <DeleteIcon @click="deleteBank(bank)"
                                    class="w-8 hover:cursor-pointer hover:bg-red-600 hover:text-white rounded-md p-1" />

                                <EditIcon @click="edit(bank)"
                                    class="w-8 hover:cursor-pointer hover:bg-blue-600 hover:text-white rounded-md p-1" />

                                <Spinner v-if="api.isLoading.value && deletingBankId === bank.id"
                                    class="button-spinner-center action-btn" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <Pagination :links="props.banks.links" />
        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: 'Banks'
}
</script>
<style scoped>
.clickable {
    cursor: pointer;
}

.disabled {
    cursor: not-allowed;
    opacity: 0.5;
    /* You can adjust the opacity as needed */
    pointer-events: none;
}
th span{
    font-size: 9px;
}
</style>
