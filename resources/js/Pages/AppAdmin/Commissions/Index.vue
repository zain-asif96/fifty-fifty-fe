<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Edit from "@/Pages/AppAdmin/Commissions/Edit.vue";
import Add from "@/Pages/AppAdmin/Commissions/Add.vue";

import Pagination from "@/Components/Custom/Pagination.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Spinner from "@/Components/Custom/Spinner.vue";
import EditIcon from "@/Icons/EditIcon.vue";

import { ref, reactive, onMounted } from "vue";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";
import TextInput from "@/Components/TextInput.vue";
import { request, BASE_URL } from "@/helpers/requestHelper.js";
import { useHelpers } from "@/Composables/useHelpers";
import { userUserStore } from "@/stores/user";

const api = useAPI();
const notification = useNotificationStore();
const props = defineProps({
    commissions: {
        required: true,
        type: Object
    },
})
// console.log('commissions', props.commissions);
// Adding
// const commissionAdded = (data) => {
//     // props.commissions.data.push(data.data);
//     props.commissions.data.unshift(data.data)
//     props.commissions.total++;

// }

// Editing:
const editingCommission = reactive({});
var showEditDialog = ref(false);
var showAddDialog = ref(false);

const allCommission = ref({})

var index = ref()
const edit = (commission) => {
    editingCommission.value = { ...commission };
    index.value = allCommission.value.data.findIndex(oldInfo => oldInfo.id === editingCommission.value.id);
    console.log(' index.value', index.value);

    showEditDialog.value = true;
    Edit;
    return { showEditDialog, Edit };
}
const add = () => {

    showAddDialog.value = true;
    Add;
    return { showAddDialog, Add };
}
function closeEditDialog($isFetchData) {
    console.log('closeEditDialog', $isFetchData);
    if ($isFetchData) {
        let tempCommison = allCommission.value.data
        tempCommison?.splice(index.value, 1, $isFetchData);
        showEditDialog.value = false;
        index.value = null
    }


    return { showEditDialog };
}
function closeAddDialog($isFetchData) {
    console.log('closeEditDialog', $isFetchData);
    if ($isFetchData) {
        let tempCommission = allCommission.value.data
        tempCommission?.unshift($isFetchData);
        allCommission.value.data = tempCommission
        showAddDialog.value = false;
        index.value = null
    }


    return { showEditDialog };
}


const fetchingcommissions = ref(false);

onMounted(() => {

    getAllCommissions()


});

const getAllCommissions = async () => {

    try {
        let res = await request({ type: 'get', url: `commissions/all` })
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
            allCommission.value = { ...res?.data?.data, data }
            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}

</script>

<template>
    <Edit :show="showEditDialog" :commissionsData="editingCommission" v-if="showEditDialog"
        v-on:close="closeEditDialog($event)" />
    <Add :show="showAddDialog" v-if="showAddDialog" v-on:close="closeAddDialog($event)" />

    <Head title="Commission Settings">
        <title>
            Commission Settings
        </title>
    </Head>

    <AdminLayout>
        <div class="ml-4 md:ml-8 mr-4 md:mr-8">
            <div class="mt-16 mb-8 text-xl flex items-center justify-between">
                <div>
                    commissions
                </div>
                <div class="text-sm" v-if="allCommission.page">
                    Page: {{ allCommission.page }}
                    | total: {{ allCommission.total }}
                    | from: {{ allCommission.from }},
                    to: {{ allCommission.to }}
                </div>
            </div>
            <button type="button" @click="add"
                class="mb-8 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Add new commission
            </button>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3" scope="col" @click="sort('id')">
                                Sr.No#
                            </th>
                            <th class="px-6 py-3" scope="col" @click="sort('from')">
                                From
                            </th>
                            <th class="px-6 py-3" scope="col" @click="sort('to')">
                                To
                            </th>
                            <th class="px-6 py-3" scope="col" @click="sort('amount')">
                                Amount
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(commission, key) in allCommission.data" :key="commission.id"
                            class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{ key + 1 }}
                            </td>

                            <td class="px-6 py-3" scope="col">
                                <p>
                                    {{ commission.from }}
                                </p>
                            </td>
                            <td class="px-6 py-3" scope="col">
                                <p>
                                    {{ commission.to }}
                                </p>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" scope="row">
                                {{ commission.amount }}
                            </td>
                            <td class="px-6 py-3" scope="col">
                                <EditIcon @click="edit(commission)"
                                    class="w-8 hover:cursor-pointer hover:bg-blue-600 hover:text-white rounded-md p-1" />
                                <Spinner v-if="api.isLoading.value && selectedcommissionId.value === commission.id"
                                    class="button-spinner-center action-btn" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- <Pagination :links="props.commissions.links" /> -->
        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: 'commissions/Index'
}
</script>

<style scoped></style>
