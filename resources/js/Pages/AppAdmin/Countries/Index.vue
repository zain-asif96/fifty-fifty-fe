<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Custom/Pagination.vue";
import { Head } from '@inertiajs/vue3';
import CreateCountry from "@/Pages/AppAdmin/Countries/partials/CreateCountry.vue";
import EditCountry from "@/Pages/AppAdmin/Countries/partials/EditCountry.vue";
import { reactive, ref, onMounted } from "vue";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";
import EditIcon from "@/Icons/EditIcon.vue";
import Spinner from "@/Components/Custom/Spinner.vue";
import { router } from '@inertiajs/vue3'
import { useSortingStore } from "@/stores/sorting";
import TextInput from "@/Components/TextInput.vue";
import { useHelpers } from "@/Composables/useHelpers";
import { request, BASE_URL } from "@/helpers/requestHelper.js";


const api = useAPI();
const helpers = useHelpers()

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

//vars
const allCountries = ref({})
const allCurrencies = ref({})



// Adding
const countryAdded = (res) => {
    allCountries.value.total = allCountries.value.total + 1

    let tempCountry = allCountries.value.data
    tempCountry.unshift(res)

    allCountries.value.total = allCountries.value.total + 1;
    allCountries.value.data = tempCountry
}

const editedCountry = reactive({});

// Editing
const edit = (country) => {

    editedCountry.value = country;
}
const endEdit = (res) => {
    editedCountry.value = {}
}

const countryEdited = (country) => {
    console.log('edited', country)
    let tempCountry = allCountries.value.data
    let index = tempCountry.findIndex(oldInfo => oldInfo.id === country.id);
    tempCountry.splice(index, 1, { ...tempCountry[index], ...country });
    allCountries.value.data = tempCountry

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
    }
};

// Search
const search = () => {
    router.visit(`?page=${currentPage.value}&q=${searchValue.value}&column=${store.column}&type=${store.type}`);
}
const clearSearch = () => {
    router.visit(`?q=`);
}

onMounted(() => {

    const q = new URLSearchParams(window.location.search).get('q');
    let cpg = new URLSearchParams(window.location.search).get('page');
    currentPage.value = cpg != null ? cpg : 1

    if (!q) {
        getAllCountries(currentPage.value)

    }
    if (q) {
        getCountries(q)

        searchValue.value = q;
    }
    getAllCurrencies()
});

const getCountries = async (search = '') => {
    let query = ''
    if (search) {
        query = `query=${search}`
    }

    try {
        let res = await request({ type: 'get', url: 'countries/search/countries', query })
        if (res?.data?.data) {
            let data = res?.data?.data
            let col = new URLSearchParams(window.location.search).get('column');
            let type = new URLSearchParams(window.location.search).get('type');
            if (col && type) {
                if (type === 'asc') {
                    data = data?.sort((a, b) => isNaN(a[col]) ? a[col]?.localeCompare(b[col]) : a[col] - b[col]);

                } else {
                    data = data?.sort((a, b) => isNaN(a[col]) ? b[col]?.localeCompare(a[col]) : b[col] - a[col]);

                }
            }
            console.log({ data });
            allCountries.value = { ...allCountries.value, data }
            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}


const getAllCountries = async (page = '1', limit = '10') => {
    let query = ''
    if (page) {
        query = `page=${page}`
    }
    if (limit) {
        query += `&limit=${limit}`

    }
    try {
        let res = await request({ type: 'get', url: `countries/all/countries`, query })
        if (res?.data?.data) {
            let data = res?.data?.data?.data
            let col = new URLSearchParams(window.location.search).get('column');
            let type = new URLSearchParams(window.location.search).get('type');
            if (col && type) {
                if (type === 'asc') {
                    data = data?.sort((a, b) => isNaN(a[col]) ? a[col]?.localeCompare(b[col]) : a[col] - b[col]);

                } else {
                    data = data?.sort((a, b) => isNaN(a[col]) ? b[col]?.localeCompare(a[col]) : b[col] - a[col]);

                }
            }
            console.log({ data });
            let links = [];
            // let cpg = new URLSearchParams(window.location.search).get('page');
            // currentPage.value = cpg != null ? cpg : 1
            let temparray = [...Array(res?.data?.data?.total <= 10 ? res?.data?.data?.total : 10)]

            temparray?.map((item, index) => {
                if (index == 0) {
                    links.push({
                        label: `&laquo; Previous`, active: currentPage.value > 1 ? true : false,
                        url: null

                    })
                    links.push({
                        label: `${index + 1}`, active: currentPage.value == index + 1 ? true : false,
                        url: `/app/admin/countries?page=${index + 1}`

                    })
                } else if (index > 0) {
                    links.push({
                        label: `${index + 1}`, active: currentPage.value == index + 1 ? true : false,
                        url: `/app/admin/countries?page=${index + 1}`

                    })

                    if (temparray?.length - 1 === index) {

                        links.push({
                            label: `Next &raquo;`, active: index + 1 === currentPage.value ? true : false,
                            url: null
                        })
                    }


                }

            })

            allCountries.value = { ...res?.data?.data, data, links }

            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}


const getAllCurrencies = async () => {

    try {
        let res = await request({ type: 'get', url: `currencies/all`, })
        if (res?.data?.data) {
            let data = res?.data?.data?.data

            console.log({ data });

            allCurrencies.value = { ...res?.data?.data, data }
            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}

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
                <div class="text-sm" v-if="allCountries.page">
                    Page: {{ allCountries.page }}
                    | total: {{ allCountries.total }}
                    | from: {{ allCountries.from }},
                    to: {{ allCountries.to }}
                </div>
            </div>

            <CreateCountry :currencies="allCurrencies" @countryAdded="countryAdded" />

            <EditCountry v-if="editedCountry.value?.id" @endEdit="endEdit" @countryEdited="countryEdited"
                :edited-country="editedCountry" :currencies="allCurrencies" />
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
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('id')">
                                #ID <span class="fw-100">{{ store.column == 'id' ? '(' + store.type + ')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('label')">
                                Country Name <span class="fw-100">{{ store.column == 'label' ? '(' + store.type + ')' : ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('name')">
                                Currency <span class="fw-100">{{ store.column == 'name' ? '(' + store.type + ')' : ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('can_send')">
                                Sending Countries <span class="fw-100">{{ store.column == 'can_send' ? '(' + store.type +
                                    ')' :
                                    '' }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('can_receive')">
                                Receiving Countries <span class="fw-100">{{ store.column == 'can_receive' ?
                                    '(' + store.type + ')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('status')">
                                Status <span class="fw-100">{{ store.column == 'status' ? '(' + store.type + ')' : ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="country in allCountries.data" :key="country.id" v-show="country.id !== 'deleted'"
                            class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" scope="row">
                                {{ country.id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ country.label }} ({{ country.code }})
                            </td>
                            <td class="px-6 py-4">
                                <span v-if="country.currency?.name || country.currency?.code">

                                    {{ country.currency?.name }} ({{ country.currency?.code }})
                                </span>
                                <span v-else>
                                    N/A
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                {{ country.can_send }}
                            </td>
                            <td class="px-6 py-4">
                                {{ country.can_receive }}
                            </td>
                            <td class="px-6 py-4">
                                <!-- update this code when you add the status column in countries -->
                                {{ country.status ? country.status : 'N/A' }}
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

            <!-- <Pagination :links="allCountries.links" /> -->
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

th span {
    font-size: 9px;
}
</style>
