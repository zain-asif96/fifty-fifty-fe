<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Custom/Pagination.vue";
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, onMounted } from "vue";
import TextInput from "@/Components/TextInput.vue";

import { useSortingStore } from "@/stores/sorting";
const props = defineProps({
    users: {
        required: true,
        type: Object
    }
})
// sorting
var searchValue = ref('');
var disableClick = ref(false)
var currentPage = ref(1)

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
    <Head title="Users">
        <title>
            Users
        </title>
    </Head>

    <AdminLayout>
        <div class="ml-4 md:ml-16">
            <div class="mt-16 mb-8 text-xl flex items-center justify-between">
                <div>
                    Users
                </div>
                <div class="text-sm">
                    Page: {{ props.users.current_page }}
                    | total: {{ props.users.total }}
                    | from: {{ props.users.from }},
                    to: {{ props.users.to }}
                </div>
            </div>

            <div class="flex items-end gap-3 ">
                <TextInput v-model="searchValue" class="mb-8" label="Search by" placeholder="Search" title="searchValue"
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
                            <th class="px-6 py-3"  :class="disableClick ? 'disabled' : 'clickable'"  scope="col" @click="sort('first_name')">
                                Name <span class="fw-100">{{ store.column == 'first_name' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3"  :class="disableClick ? 'disabled' : 'clickable'"  scope="col" @click="sort('email')">
                                Email <span class="fw-100">{{ store.column == 'email' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3"  :class="disableClick ? 'disabled' : 'clickable'"  scope="col" @click="sort('phone')">
                                Phone <span class="fw-100">{{ store.column == 'phone' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3"  :class="disableClick ? 'disabled' : 'clickable'"  scope="col" @click="sort('country')">
                                Country Code <span class="fw-100">{{ store.column == 'country' ? '('+store.type+')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3"  :class="disableClick ? 'disabled' : 'clickable'"  scope="col" @click="sort('ip_address')">
                                IP Address <span class="fw-100">{{ store.column == 'ip_address' ? '('+store.type+')' : '' }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in props.users.data" :key="user.id"
                            class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" scope="row">
                                <Link :href="route('single.user.page', user.id)"
                                    class="text-blue-700 hover:text-blue-900 hover:underline">
                                {{ user.first_name }} {{ user.last_name }}
                                </Link>
                            </th>
                            <td class="px-6 py-4">
                                {{ user.email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ user.phone }}
                            </td>
                            <td class="px-6 py-4">
                                {{ user.country }}
                            </td>
                            <td class="px-6 py-4">
                                {{ user.ip_address }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <Pagination :links="props.users.links" />
        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: 'Users'
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
