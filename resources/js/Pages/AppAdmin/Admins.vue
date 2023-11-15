<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Custom/Pagination.vue";
import { Head } from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import { ref, onMounted, onBeforeMount, watch } from "vue";
import { request } from "@/helpers/requestHelper.js";

import { router } from '@inertiajs/vue3'
import { useSortingStore } from "@/stores/sorting";
import axios from "axios";

const props = defineProps({
    admins: {
        required: true,
        type: Object
    }
})
// sorting
var currentPage = ref(1)
var searchValue = ref('');
const adminList = ref([])
const time = ref()

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
    // router.visit(`?q=${searchValue.value}&column=${store.column}&type=${store.type}`);

}
const clearSearch = () => {
    router.visit(`?q=`);
}
onBeforeMount(() => {
    let q = new URLSearchParams(window.location.search).get('q');
    let cpg = new URLSearchParams(window.location.search).get('page');
    currentPage.value = cpg != null ? cpg : 1
    if (!q) {
        getAllAdmins(currentPage.value)
    }
    if (q) {
        getAdmins(q)

        searchValue.value = q;
    }

})

const getAdmins = async (search = '', type = 'super.admin') => {
    let query = ''
    if (search) {
        query = `query=${search}`
    }
    if (type) {
        query += `&type=${type}`

    }
    try {
        let res = await request({ type: 'get', url: 'user-auth/search', query })
        console.log({ res });
        if (res?.data?.data) {
            let data = res?.data?.data
            let col = new URLSearchParams(window.location.search).get('column');
            let type = new URLSearchParams(window.location.search).get('type');
            if (col && type) {
                if (type === 'asc') {
                    data = data?.sort((a, b) => a[col].localeCompare(b[col]));

                } else {
                    data = data?.sort((a, b) => b[col].localeCompare(a[col]));

                }
            }
            adminList.value = { ...adminList.value, data }
            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}

const getAllAdmins = async (page = '1', limit = '10') => {
    let query = ''
    if (page) {
        query = `page=${page}`
    }
    if (limit) {
        query += `&limit=${limit}`

    }
    try {
        let res = await request({ type: 'get', url: `user-auth/getAll`, query })
        console.log({ res });
        if (res?.data?.data) {
            let data = res?.data?.data?.data
            let col = new URLSearchParams(window.location.search).get('column');
            let type = new URLSearchParams(window.location.search).get('type');
            if (col && type) {
                if (type === 'asc') {
                    data = data?.sort((a, b) => a[col].localeCompare(b[col]));

                } else {
                    data = data?.sort((a, b) => b[col].localeCompare(a[col]));

                }
            }
            // if (data?.length) {
            //     data = data?.filter((dt) => dt?.role === 'super.admin')
            // }
            console.log({ data });
            adminList.value = { ...res?.data?.data, data }
            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}





</script>

<template>
    <Head title="Admins">
        <title>
            Admins
        </title>
    </Head>
    <AdminLayout>
        <div class="ml-4 md:ml-16">
            <div class="mt-16 mb-8 text-xl flex items-center justify-between">
                <div>
                    Admins
                </div>
                <div class="text-sm" v-if="adminList.page">
                    Page: {{ adminList.page }}
                    | total: {{ adminList.total }}
                    | from: {{ adminList.from }},
                    to: {{ adminList.to }}
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
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('name')">
                                Name <span class="fw-100">{{ store.column == 'name' ? '(' + store.type + ')' : ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('email')">
                                Email <span class="fw-100">{{ store.column == 'email' ? '(' + store.type + ')' : ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('phone')">
                                Phone <span class="fw-100">{{ store.column == 'phone' ? '(' + store.type + ')' : ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('country_code')">
                                Country Code <span class="fw-100">{{ store.column == 'country_code' ? '(' + store.type + ')'
                                    : ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('ip')">
                                IP Address <span class="fw-100">{{ store.column == 'ip' ? '(' + store.type + ')' :
                                    ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col">
                                <!--                                @click="sort('role')"-->
                                Role <span class="fw-100">{{ store.column == 'role' ? '(' + store.type + ')' : '' }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="admin in adminList?.data" :key="admin.id"
                            class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" scope="row">
                                {{ admin.name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ admin.email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ admin.phone }}
                            </td>
                            <td class="px-6 py-4">
                                {{ admin.country_code }}
                            </td>
                            <td class="px-6 py-4">
                                {{ admin.ip }}
                            </td>
                            <td class="px-6 py-4">
                                {{ admin.role }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- <Pagination :links="props.admins.links" /> -->
        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: 'Admins'
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

th span {
    font-size: 9px;
}
</style>
