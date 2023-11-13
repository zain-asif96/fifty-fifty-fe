<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Edit from "@/Pages/Admin/Commissions/Edit.vue";
// import Add from "@/Pages/Admin/commission/Add.vue";

import Pagination from "@/Components/Custom/Pagination.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Spinner from "@/Components/Custom/Spinner.vue";
import EditIcon from "@/Icons/EditIcon.vue";

import { ref, reactive, onMounted } from "vue";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";

import TextInput from "@/Components/TextInput.vue";

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

var index = ref()
const edit = (commission) => {
    editingCommission.value = { ...commission };
    index.value = props.commissions.data.findIndex(oldInfo => oldInfo.id === editingCommission.value.id);
    console.log(' index.value', index.value);

    showEditDialog.value = true;
    Edit;
    return { showEditDialog, Edit };
}
function closeEditDialog($isFetchData) {
    console.log('closeEditDialog', $isFetchData);
    if ($isFetchData) {
        props.commissions.data.splice(index.value, 1, $isFetchData);
        showEditDialog.value = false;
        index.value = null
    }


    return { showEditDialog };
}


const fetchingcommissions = ref(false);


</script>

<template>
    <Edit :show="showEditDialog" :commissionsData="editingCommission" v-if="showEditDialog"
        v-on:close="closeEditDialog($event)" />

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
                <div class="text-sm">
                    Page: {{ props.commissions.current_page }}
                    | total: {{ props.commissions.total }}
                    | from: {{ props.commissions.from }},
                    to: {{ props.commissions.to }}
                </div>
            </div>
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
                        <tr v-for="(commission, key) in props.commissions.data" :key="commission.id"
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

            <Pagination :links="props.commissions.links" />
        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: 'commissions/Index'
}
</script>

<style scoped></style>
