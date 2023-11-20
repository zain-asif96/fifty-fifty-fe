<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Add from "@/Pages/AppAdmin/Posts/partials/Add.vue";
import Edit from "@/Pages/AppAdmin/Posts/partials/Edit.vue";

import Pagination from "@/Components/Custom/Pagination.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { useSortingStore } from "@/stores/sorting";
import Spinner from "@/Components/Custom/Spinner.vue";
import DeleteIcon from "@/Icons/DeleteIcon.vue";
import RefreshIcon from "@/Icons/RefreshIcon.vue";

import { ref, reactive, onMounted } from "vue";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";
import EditIcon from "@/Icons/EditIcon.vue";
import TextInput from "@/Components/TextInput.vue";
import { request, BASE_URL } from "@/helpers/requestHelper.js";
import { userUserStore } from "@/stores/user";

const api = useAPI();
const notification = useNotificationStore();
const $userStore = userUserStore();
let token = $userStore.getUserApp
    ? $userStore.getUserApp?.data?.auth_token
    : "";

const props = defineProps({
    posts: {
        required: true,
        type: Object
    },
    receivers: {
        required: true,
        type: Object
    }

})

console.log('receivers', props.receivers);
// Adding
const postAdded = (data) => {
    console.log('data after adding ', data);
    // props.posts.data.push(data.data);
    props.posts.data.unshift(data.data)
    props.posts.total++;

}

// Editing:
const editingPost = reactive({});
var showEditDialog = ref(false);
const allPosts = ref({});
const allReveiver = ref({});



var index = ref()

const edit = (post) => {
    editingPost.value = { ...post };
    console.log({ editingPost: editingPost.value, allPosts: allPosts.value });
    index.value = allPosts.value.data?.findIndex(oldInfo => oldInfo.id === editingPost.value.id);
    console.log(' index.value', index.value);

    showEditDialog.value = true;
    Edit;
    return { showEditDialog, Edit };
}
function closeEditDialog($isFetchData) {
    let tempdata = allPosts.value.data
    tempdata.splice(index.value, 1, { ...tempdata[index.value], status: $isFetchData?.status, receiver_amount: $isFetchData?.receiver_amount });

    allPosts.value = { ...allPosts.value, data: tempdata }
    showEditDialog.value = false;
    index.value = null

    return { showEditDialog };
}
// refreshing

let selectedPostId = ref();
const refreshPost = async (post) => {
    console.log('post', post);
    selectedPostId.value = post.id;
    index.value = allPosts.value.data.findIndex(oldInfo => oldInfo.id === post.id);
    console.log('index.value', index.value);
    console.log('selectedPostId.value', selectedPostId.value);
    api.startRequest();

    try {
        const res = await axios.get(`${BASE_URL}/posts/` + post.id)
        console.log('res refresh', res);

        if (res.data.status === 'OK') {
            notification.notify('Post Refereshed', 'success');
            // props.posts.rows.splice(index.value, 1);

            let temp = allPosts.value.data
            temp?.splice(index.value, 1, { ...temp[index.value], ...res.data.data });
            // props.posts.data.splice(index.value, 1, res.data.data);
            console.log({ temp });
            allPosts.value = { ...allPosts.value, data: temp }
            index.value = null
        }
    } catch (errors) {
        notification.notify('Error, this base post can not be refreshed.', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
}
// Deleting

const deletePost = async (post) => {
    console.log(post);
    selectedPostId.value = post.id;
    index.value = allPosts.data.findIndex(oldInfo => oldInfo.id === post.id);
    console.log('index.value', index.value);
    api.startRequest();

    try {
        const res = await axios.delete(`${BASE_URL}/posts/delete/` + post.id, {
            headers: { Authorization: `Bearer ${token}` },
        })

        if (res.data.id || res.data.status === 'success') {
            notification.notify('Post deleted', 'success');
            // post.id = 'deleted';
            // props.posts.total--;
            let temp = allPosts.value?.data?.splice(index.value, 1)
            // props.posts.rows.splice(index.value, 1);
            allPosts.value = { ...allPosts.value, total: allPosts.value?.total - 1, data: temp }
            index.value = null
        }
    } catch (errors) {
        notification.notify('Error, this base post can not be deleted.', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
}

const fetchingposts = ref(false);


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
        getAllPosts(currentPage.value)
    }
    if (q) {
        getPosts(q)
        searchValue.value = q;
    }
    getAllReceiver(currentPage.value)
});

// class of the status
function getClass(status) {
    let flag = "info"
    if (status == 'available') {
        flag = 'success'
    } else if (status == "on_hold") {
        flag = 'danger'
    }
    return flag;
}

const getPosts = async (search = '') => {
    let query = ''
    if (search) {
        query = `query=${search}`
    }

    try {
        let res = await request({ type: 'get', url: 'posts/search/posts', query })
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
            allPosts.value = { ...allPosts.value, data }
            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}

const getAllPosts = async (page = '1', limit = '10') => {
    let query = ''
    if (page) {
        query = `page=${page}`
    }
    if (limit) {
        query += `&limit=${limit}`

    }
    try {
        let res = await request({ type: 'get', url: `posts/all/posts`, query })
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
            console.log({ data });
            allPosts.value = { ...res?.data?.data, data }
            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}

const getAllReceiver = async (page = '1', limit = '100') => {
    let query = ''
    if (page) {
        query = `page=${page}`
    }
    if (limit) {
        query += `&limit=${limit}`

    }
    try {
        let res = await request({ type: 'get', url: `receivers/getAll`, query })
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
            console.log({ dataaaa: data });
            allReveiver.value = { ...res?.data?.data, data }
            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}


</script>

<template>
    <Edit :show="showEditDialog" :postData="editingPost" v-if="showEditDialog" v-on:close="closeEditDialog($event)" />

    <Head title="Posts">
        <title>
            Posts
        </title>
    </Head>

    <AdminLayout>
        <div class="ml-4 md:ml-8 mr-4 md:mr-8">
            <div class="mt-16 mb-8 text-xl flex items-center justify-between">
                <div>
                    Posts
                </div>
                <div class="text-sm" v-if="allPosts?.page">
                    Page: {{ allPosts?.page }}
                    | total: {{ allPosts.total }}
                    | from: {{ allPosts.from }},
                    to: {{ allPosts.to }}
                </div>
            </div>

            <!-- <Add :receivers="allReveiver" @postAdded="postAdded" /> -->
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
                                @click="sort('created_at')">
                                Initialized <span class="fw-100">{{ store.column == 'created_at' ? '(' + store.type + ')' :
                                    ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('status')">
                                Status <span class="fw-100">{{ store.column == 'status' ? '(' + store.type + ')' : ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('user')">
                                Country from <span class="fw-100">{{ store.column == 'user' ? '(' + store.type + ')' : ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('receiver')">
                                Country To <span class="fw-100">{{ store.column == 'receiver' ? '(' + store.type + ')' : ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('amount')">
                                Amount <span class="fw-100">{{ store.column == 'amount' ? '(' + store.type + ')' : ''
                                }}</span>
                            </th>
                            <th class="px-6 py-3" :class="disableClick ? 'disabled' : 'clickable'" scope="col"
                                @click="sort('id')">
                                Direct Transaction Reference <span class="fw-100">{{ store.column == 'id' ?
                                    '(' + store.type + ')' : '' }}</span>
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="post in allPosts?.data" :key="post.id"
                            class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{ post.created_at }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" scope="row">
                                <span :class="getClass(post.status)"> {{ post.status?.replaceAll('_', ' ') }}</span>
                            </td>
                            <td class="px-6 py-3" scope="col">
                                <p>
                                    {{ post?.user?.country_code }}
                                </p>
                                <p v-if="post.user?.id">
                                    <Link :href="post.user?.id ? route('app.single.user.page', post.user?.id) : ''"
                                        class="text-blue-700 hover:text-blue-900 hover:underline">
                                    (View sender)
                                    </Link>
                                </p>
                            </td>
                            <td class="px-6 py-3" scope="col">
                                <p>
                                    {{ post.receiver?.country_code }}
                                </p>
                                <p v-if="post.receiver?.id">
                                    <Link
                                        :href="post.receiver?.id ? route('app.single.receiver.page', post.receiver.id) : ''"
                                        class="text-blue-700 hover:text-blue-900 hover:underline">
                                    (View receiver)
                                    </Link>
                                </p>
                            </td>
                            <td class="px-6 py-3" scope="col">
                                <p>
                                    {{ parseFloat(post.receiver_amount / 100) }}
                                    <span class="uppercase" v-if="post.receiver_currency">
                                        ({{ post.receiver_currency }})
                                    </span>

                                </p>

                                <Link v-if="post.transaction?.payment_intent?.id"
                                    :href="post.transaction?.payment_intent?.id ? route('payment.intent.page', post.transaction.payment_intent.id) : ''"
                                    class="text-blue-700 hover:text-blue-900 hover:underline">
                                (View Payment Intent)
                                </Link>
                            </td>
                            <td class="px-6 py-3 uppercase" scope="col">
                                #{{ post.transaction?.id }}
                            </td>
                            <td class="px-6 py-3" scope="col">
                                <DeleteIcon @click="deletePost(post)"
                                    class="w-8 hover:cursor-pointer hover:bg-red-600 hover:text-white rounded-md p-1" />

                                <EditIcon @click="edit(post)"
                                    class="w-8 hover:cursor-pointer hover:bg-green-600 hover:text-white rounded-md p-1" />

                                <RefreshIcon @click="refreshPost(post)" v-if="post.status == 'on_hold'"
                                    class="w-8 hover:cursor-pointer hover:bg-blue-600 hover:text-white rounded-md p-1" />

                                <Spinner v-if="api.isLoading.value && selectedPostId.value === post.id"
                                    class="button-spinner-center action-btn" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- <Pagination :links="props.posts.links" /> -->
        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: 'Posts/Index'
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

svg.bi.bi-arrow-clockwise.w-8.hover\:cursor-pointer.hover\:bg-blue-600.hover\:text-white.rounded-md.p-1 {
    height: 30px;
}

.danger {
    background-color: #ff6666;
    color: white;
    padding: 2px 4px;
    font-size: 13px;
    border-radius: 3px;

}

.success {
    background-color: #2dcb2d;
    color: white;
    padding: 2px 4px;
    font-size: 13px;
    border-radius: 3px;
}

.info {
    background-color: #4dd8ff;
    color: white;
    padding: 2px 4px;
    font-size: 13px;
    border-radius: 3px;
}
</style>
