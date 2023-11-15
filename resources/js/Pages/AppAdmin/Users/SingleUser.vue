<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router } from '@inertiajs/vue3';
import { useHelpers } from "@/Composables/useHelpers";
import SimpleButton from "@/Components/Custom/SimpleButton.vue";
import { request } from "@/helpers/requestHelper.js";
import { onMounted, ref } from "vue";

const props = defineProps({
    user: {
        required: true,
        type: Object
    }
})


const helpers = useHelpers()
const userData = ref({})
onMounted(() => {
    getSingleUser(props?.user)
})

const getSingleUser = async (id = '',) => {
    let params = id

    try {
        let res = await request({ type: 'get', url: `user-auth/findById`, params })
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

            userData.value = { ...res?.data?.data, data }
            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}
</script>

<template>
    <Head title="Single User">
        <title>
            Single User
        </title>
    </Head>

    <AdminLayout>
        <div class="ml-4 md:ml-16">
            <div class="mt-16 mb-8 text-xl flex items-center justify-between">
                <div>
                    <span class="text-gray-500">User:</span> {{ userData.name }}
                </div>
            </div>

            <div class="flex flex-col mt-12 mb-12">
                <div class="flex mt-2">
                    <div class="w-32">First name:</div>
                    <div class="font-semibold">{{ userData.name?.split(" ")?.length > 0 ? userData.name.split(" ")[0] :
                        userData.name }}
                    </div>
                </div>

                <div class="flex mt-2">
                    <div class="w-32">Last name:</div>
                    <div class="font-semibold">{{ userData.name?.split(" ")?.length > 1 ?
                        userData.name.split(" ")[1]
                        : userData.name }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-32">Email:</div>
                    <div class="font-semibold">{{ userData.email }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-32">Phone:</div>
                    <div class="font-semibold">{{ userData.phone }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-32">Country:</div>
                    <div class="font-semibold">{{ helpers.getCountryLabelByCode(userData.country_code) }}
                        ({{ userData.country_code }})
                    </div>
                </div>

                <div class="flex mt-2">
                    <div class="w-32">IP Address:</div>
                    <div class="font-semibold">{{ userData.ip }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-32">Joined at:</div>
                    <div class="font-semibold">{{ userData.created_at }}</div>
                </div>
            </div>


            <SimpleButton @click="router.get(route('app.users.page'))">
                Back to users list
            </SimpleButton>

        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: 'SingleUser'
}
</script>
