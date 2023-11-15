<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Custom/Pagination.vue";
import { Head } from "@inertiajs/vue3";
import CreateCurrency from "@/Pages/Admin/Currencies/partials/CreateCurrency.vue";
import EditCurrency from "@/Pages/Admin/Currencies/partials/EditCurrency.vue";
import Spinner from "@/Components/Custom/Spinner.vue";
import DeleteIcon from "@/Icons/DeleteIcon.vue";
// import ArrowDown from "@/Icons/ArrowDown.vue";
// import ArrowUp from "@/Icons/ArrowUp.vue";
import EditIcon from "@/Icons/EditIcon.vue";
import { ref, reactive, onMounted } from "vue";
import { useAPI } from "@/Composables/useAPI";
import { useSortingStore } from "@/stores/sorting";
import { useNotificationStore } from "@/stores/notification";
import SaveIcon from "@/Icons/SaveIcon.vue";
import TextInput from "@/Components/TextInput.vue";
// import ToggleSwitch from "@/Components/Custom/ToggleSwitch.vue";
import { router } from '@inertiajs/vue3'

const api = useAPI();
const notification = useNotificationStore();
const props = defineProps({
    currencies: {
        required: true,
        type: Object
    },
    info: {
        type: Object,
        default: ''
    }
})
// Editing:
const editingCurrency = reactive({});
var showEditDialog = ref(false);

var index = ref()
const edit = (currency) => {
    editingCurrency.value = { ...currency };
    index.value = props.currencies.data.findIndex(oldInfo => oldInfo.id === editingCurrency.value.id);
    console.log(' index.value', index.value);

    showEditDialog.value = true;
    EditCurrency;
    return { showEditDialog };
}
function closeEditDialog($isFetchData) {
    console.log('$isFetchData', $isFetchData);
    if ($isFetchData) {
        props.currencies.data.splice(index.value, 1, $isFetchData);
    }
    showEditDialog.value = false;
    return { showEditDialog };
}
// let toggleStatus= ref(false)
const updateRate = (currency) => {
    console.log('currency', currency);
    if (currency.toggleStatus) {
        // If toggle is ON, update the rate to special_rate
        currency.updatedRate = currency.toggleStatus ? currency.special_rate : currency.rate;
        currency.rate_source = 'special';
    } else {
        // If toggle is OFF, show normal rate (if available), otherwise set to 0
        currency.updatedRate = currency.toggleStatus ? currency.special_rate : currency.rate;
        currency.rate_source = 'world_bank';
    }
};

// Adding
const currencyAdded = () => {
    props.currencies.total++;
}

// Deleting
const deleteCurrency = async (currency) => {
    deletingCurrencyId.value = currency.id;

    api.startRequest();

    try {
        const res = await axios.delete('/admin/currencies/delete/' + currency.id)

        if (res.data.id || res.data.status === 'success') {
            notification.notify('Currency deleted', 'success');
            currency.id = 'deleted';
            props.currencies.total--;
        }
    } catch (errors) {
        notification.notify('Error, this base currency can not be deleted.', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
}

const fetchingCurrencies = ref(false);

// Updating rates:
const updateCurrencyRates = async () => {
    api.startRequest();
    fetchingCurrencies.value = true;

    try {
        const res = await axios.put('/admin/currencies/update-rates')

        if (res.data.status === 'success') {
            notification.notify('Currency rates updated', 'success');
            props.currencies.data = res.data.currencies;
            props.info.fetched_at = res.data.fetched_at;
        }
    } catch (errors) {
        notification.notify('Error, could not fetch world bank rates.', 'error');
        api.handleErrors(errors)
    } finally {
        fetchingCurrencies.value = false;
        api.requestCompleted();
    }
}
var currentPage = ref(1)

// Search
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
function setStatus(currency) {
    // if (condition) {

    // } else {

    // }
    return true
    console.log('this is trest', currency);
}
</script>

<template>
    <EditCurrency :show="showEditDialog" :currencyData="editingCurrency" v-if="showEditDialog"
        v-on:close="closeEditDialog($event)" />

    <Head title="Currencies">
        <title>
            Currencies
        </title>
    </Head>

    <AdminLayout>
        <div class="ml-4 md:ml-8 mr-4 md:mr-8">
            <div class="mt-16 mb-8 text-xl flex items-center justify-between">
                <div>
                    Currencies
                </div>
                <div class="text-sm">
                    Page: {{ props.currencies.current_page }}
                    | total: {{ props.currencies.total }}
                    | from: {{ props.currencies.from }},
                    to: {{ props.currencies.to }}
                </div>
            </div>

            <CreateCurrency @currencyAdded="currencyAdded" />

            <div class="flex items-center">
                <button @click="updateCurrencyRates" type="button"
                    class="mb-8 flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Fetch world bank rates

                    <Spinner v-if="api.isLoading.value && fetchingCurrencies"
                        class="ml-3 button-spinner-center action-btn" />
                </button>

                <div class="mb-8" v-if="info.fetched_at">
                    Last fetched: {{ info.fetched_at }}
                </div>
            </div>

            <div class="flex items-end gap-3 ">
                <TextInput v-model="searchValue" class="mb-8" label="Search by currency code" placeholder="Search"
                    title="searchValue" v-on:keyup.enter="search" />

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
                            <th class="px-6 py-3 cursor-pointer" :class="disableClick ? 'disabled' : 'clickable'"
                                scope="col" @click="sort('name')">
                                Country <span class="fw-100">{{ store.column == 'name' ? '(' + store.type + ')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3 cursor-pointer" :class="disableClick ? 'disabled' : 'clickable'"
                                scope="col" @click="sort('code')">
                                Currency Code <span class="fw-100">{{ store.column == 'code' ? '(' + store.type + ')' : ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3 cursor-pointer" :class="disableClick ? 'disabled' : 'clickable'"
                                scope="col" @click="sort('name')">
                                Currency name <span class="fw-100">{{ store.column == 'name' ? '(' + store.type + ')' : ''
                                }}</span>
                            </th>


                            <th class="px-6 py-3" scope="col">
                                Switch <span class="fw-100">{{ store.column == 'role' ? '(' + store.type + ')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Rate <span class="fw-100">{{ store.column == 'role' ? '(' + store.type + ')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3 cursor-pointer" :class="disableClick ? 'disabled' : 'clickable'"
                                scope="col" @click="sort('rate_source')">
                                Rate source (WB/Special) <span class="fw-100">{{ store.column == 'rate_source' ?
                                    '(' + store.type + ')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="currency in props.currencies.data" :key="currency.id" v-show="currency.id !== 'deleted'"
                            class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <td class="px-6 py-4">
                                <span>{{ currency.country ? currency.country.label : 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span>{{ currency.code }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span>{{ currency.name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <!-- <ToggleSwitch  :class="currency.toggleStatus == 'special' ? 'slider-checked' : ''"
                                :id="'toggle_' + currency.id" v-model="currency.toggleStatus"
                                    @click="updateRate(currency)" /> -->
                                <input type="checkbox" :class="currency.rate_source == 'special' ? 'slider-checked' : ''"
                                    class="slider" :id="'toggle_' + currency.id" v-model="currency.toggleStatus"
                                    @change="updateRate(currency)" />
                                <label :for="'toggle_' + currency.id" class="slider round"></label>
                            </td>
                            <td>
                                <input type="number" class="w-20 text-black" v-model="currency.rate"
                                    v-if="currency.editing" />

                                <span>{{ currency.rate_source == 'special' ? parseFloat(currency.special_rate).toFixed(2) :
                                    parseFloat(currency.rate).toFixed(2) }}</span>
                            </td>
                            <td class="px-6 py-4 uppercase">
                                <span> {{ currency.rate_source.replace('_', ' ') }} </span>
                            </td>

                            <td class="px-6 py-4 flex gap-4 items-center">
                                <DeleteIcon @click="deleteCurrency(currency)"
                                    class="w-8 hover:cursor-pointer hover:bg-red-600 hover:text-white rounded-md p-1" />

                                <!-- <SaveIcon v-if="editingCurrency.value?.id === currency.id" @click="applyEdit"
                                    class="w-8 hover:cursor-pointer hover:bg-green-600 hover:text-white rounded-md p-1" /> -->

                                <EditIcon @click="edit(currency)"
                                    class="w-8 hover:cursor-pointer hover:bg-blue-600 hover:text-white rounded-md p-1" />

                                <Spinner v-if="api.isLoading.value && deletingCurrencyId === currency.id"
                                    class="button-spinner-center action-btn" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <Pagination :links="props.currencies.links" />
        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: 'Currencies/Index'
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

.clickable {
    cursor: pointer;
}

.disabled {
    cursor: not-allowed;
    opacity: 0.5;
    /* You can adjust the opacity as needed */
    pointer-events: none;
}

th span {
    font-size: 9px;
}</style>
