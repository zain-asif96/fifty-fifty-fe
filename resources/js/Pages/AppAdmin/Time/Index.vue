<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Edit from "@/Pages/AppAdmin/Time/Edit.vue";
import Add from "@/Pages/AppAdmin/Time/Add.vue";

import Pagination from "@/Components/Custom/Pagination.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Spinner from "@/Components/Custom/Spinner.vue";
import EditIcon from "@/Icons/EditIcon.vue";

import { ref, reactive, onMounted } from "vue";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";

import TextInput from "@/Components/TextInput.vue";
import { request, BASE_URL } from "@/helpers/requestHelper.js";

const api = useAPI();
const notification = useNotificationStore();
const props = defineProps({
    times: {
        required: true,
        type: Object
    },
})
// console.log('times', props.times);
// Adding
const timeAdded = (data) => {
    // props.times.data.push(data.data);
    console.log({ data });
    allTimes.value.data = [data.data, ...allTimes.value.data]
    allTimes.value.total = allTimes.value.total + 1;

}

// Editing:
const editingTime = reactive({});
var showEditDialog = ref(false);

var index = ref()
const allTimes = ref({})
const currentPage = ref()

const edit = (time) => {
    editingTime.value = { ...time };
    index.value = allTimes.value.data.findIndex(oldInfo => oldInfo.id === editingTime.value.id);
    console.log(' index.value', index.value);

    showEditDialog.value = true;
    Edit;
    return { showEditDialog, Edit };
}
function closeEditDialog($isFetchData) {
    console.log('closeEditDialog', $isFetchData);
    console.log({ ssasd: $isFetchData });
    if ($isFetchData?.time) {
        let tempTime = allTimes.value.data
        tempTime.splice(index.value, 1, { ...tempTime[index.value], ...$isFetchData });
        allTimes.value.data = tempTime
    }
    showEditDialog.value = false;
    index.value = null

    return { showEditDialog };
}


const fetchingtimes = ref(false);

onMounted(() => {
    let cpg = new URLSearchParams(window.location.search).get('page');
    currentPage.value = cpg != null ? cpg : 1


    getAllTimes(currentPage.value)

})


const getAllTimes = async (page = '1', limit = '10') => {
    let query = ''
    if (page) {
        query = `page=${page}`
    }
    if (limit) {
        query += `&limit=${limit}`

    }
    try {
        let res = await request({ type: 'get', url: `global_variable/list`, query })
        console.log({ res });
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
            console.log({ dataaaa: data });
            allTimes.value = { ...res?.data?.data, data }
            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}


</script>

<template>
    <Edit :show="showEditDialog" :timeData="editingTime" v-if="showEditDialog" v-on:close="closeEditDialog($event)" />

    <Head title="Time Setting">
        <title>
            Time Setting
        </title>
    </Head>

    <AdminLayout>
        <div class="ml-4 md:ml-8 mr-4 md:mr-8">
            <div class="mt-16 mb-8 text-xl flex items-center justify-between">
                <div>
                    times
                </div>
                <div class="text-sm" v-if="allTimes.page">
                    Page: {{ allTimes.page }}
                    | total: {{ allTimes.total }}
                    | from: {{ allTimes.from }},
                    to: {{ allTimes.to }}
                </div>
            </div>
            <Add @timeAdded="timeAdded" />
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3" scope="col" @click="sort('id')">
                                Sr.No#
                            </th>
                            <th class="px-6 py-3" scope="col" @click="sort('model_name')">
                                Model Name
                            </th>
                            <th class="px-6 py-3" scope="col" @click="sort('time')">
                                Time
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(time, key) in allTimes.data" :key="time.id"
                            class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{ key + 1 }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" scope="row">
                                {{ time.model_name }}
                            </td>
                            <td class="px-6 py-3" scope="col">
                                <p>
                                    {{ time.time }}
                                </p>
                            </td>
                            <td class="px-6 py-3" scope="col">
                                <EditIcon @click="edit(time)"
                                    class="w-8 hover:cursor-pointer hover:bg-blue-600 hover:text-white rounded-md p-1" />
                                <Spinner v-if="api.isLoading.value && selectedTimeId.value === time.id"
                                    class="button-spinner-center action-btn" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- <Pagination :links="props.times.links" /> -->
        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: 'times/Index'
}
</script>

<style scoped></style>
