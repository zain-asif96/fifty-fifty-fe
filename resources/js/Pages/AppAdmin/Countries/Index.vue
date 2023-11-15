<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Custom/Pagination.vue";
import { Head } from '@inertiajs/vue3';
import CreateCountry from "@/Pages/Admin/Countries/partials/CreateCountry.vue";
import EditCountry from "@/Pages/Admin/Countries/partials/EditCountry.vue";
import { reactive, ref,onMounted } from "vue";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";
import EditIcon from "@/Icons/EditIcon.vue";
import Spinner from "@/Components/Custom/Spinner.vue";
import { router } from '@inertiajs/vue3'
import { useSortingStore } from "@/stores/sorting";
import TextInput from "@/Components/TextInput.vue";


const api = useAPI();
const notification = useNotificationStore();

const props = defineProps({
    countries: {
        required: true,
        type: Object
    },
    currencies: {
        type: Array,
        required: true
    }
})


// Adding
const countryAdded = () => {
    props.countries.total++;
}

const editedCountry = reactive({});

// Editing
const edit = (country) => {
    editedCountry.value = country;
}
const endEdit = () => {
    editedCountry.value = {}
}

const countryEdited = (country) => {
    console.log('edited')
    let index = props.countries.data.findIndex(oldInfo => oldInfo.id === country.id);
    props.countries.data.splice(index, 1, country);
}

// sorting
var currentPage = ref(1)

var searchValue = ref('');
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
// Search
const search = () => {
    router.visit(`?page=${currentPage.value}&q=${searchValue.value}&column=${store.column}&type=${store.type}`);
}
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
    <Head title="Countries">
        <title>
            Countries
        </title>
    </Head>

    <AdminLayout>
        <div class="ml-4 md:ml-16">
            <div class="mt-16 mb-8 text-xl flex items-center justify-between">
                <div>
                    Countries
                </div>
                <div class="text-sm">
                    Page: {{ props.countries.current_page }}
                    | total: {{ props.countries.total }}
                    | from: {{ props.countries.from }},
                    to: {{ props.countries.to }}
                </div>
            </div>

            <CreateCountry :currencies="currencies" />

            <EditCountry v-if="editedCountry.value?.id" @endEdit="endEdit" @countryEdited="countryEdited"
                :edited-country="editedCountry" :currencies="currencies" />
            <div class="flex items-end gap-3 ">
                <TextInput v-model="searchValue" class="mb-8" label="Search" placeholder="Search"
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
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col" @click="sort('id')">
                                #ID <span class="fw-100">{{ store.column == 'id' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col" @click="sort('label')">
                                Country Name <span class="fw-100">{{ store.column == 'label' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col" @click="sort('name')">
                                Currency <span class="fw-100">{{ store.column == 'name' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col" @click="sort('can_send')">
                                Sending Countries <span class="fw-100">{{ store.column == 'can_send' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col" @click="sort('can_receive')">
                                Receiving Countries <span class="fw-100">{{ store.column == 'can_receive' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col" @click="sort('status')">
                                Status <span class="fw-100">{{ store.column == 'status' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="country in props.countries.data" :key="country.id" v-show="country.id !== 'deleted'"
                            class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" scope="row">
                                {{ country.id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ country.label }} ({{ country.code }})
                            </td>
                            <td class="px-6 py-4">
                                {{ country.currency.name }} ({{ country.currency.code }})
                            </td>
                            <td class="px-6 py-4">
                                {{ country.can_send }}
                            </td>
                            <td class="px-6 py-4">
                                {{ country.can_receive }}
                            </td>
                            <td class="px-6 py-4">
                                <!-- update this code when you add the status column in countries -->
                                {{ country.status?country.status:'N/A' }}
                            </td>
                            <td class="px-6 py-4 flex gap-4 items-center">
                                <EditIcon @click="edit(country)"
                                    class="w-8 hover:cursor-pointer hover:bg-blue-600 hover:text-white rounded-md p-1" />

                                <Spinner v-if="api.isLoading.value && deletingCountryId === country.id"
                                    class="button-spinner-center action-btn" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <Pagination :links="props.countries.links" />
        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: 'Countries'
}
</script>
<style scoped>
th:not(:last-child) {
    cursor: pointer;
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
th span{
    font-size: 9px;
}
</style>
