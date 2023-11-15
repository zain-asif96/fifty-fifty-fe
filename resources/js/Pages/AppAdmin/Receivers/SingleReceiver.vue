<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router } from '@inertiajs/vue3';
import { useHelpers } from "@/Composables/useHelpers";
import SimpleButton from "@/Components/Custom/SimpleButton.vue";
import { request, BASE_URL } from "@/helpers/requestHelper.js";
import { onMounted, ref } from "vue";

const props = defineProps({
    receiver: {
        required: true,
        type: Object
    }
})


const helpers = useHelpers()
const singleReceiver = ref({})


onMounted(() => {
    // const q = new URLSearchParams(window.location.p).get('q');
    // let cpg = new URLSearchParams(window.location.search).get('page');
    // currentPage.value = cpg != null ? cpg : 1


    getSingleReceiver(props?.receiver)


});
console.log({ props: props?.receiver });
const getSingleReceiver = async (id = '') => {
    let query = ''
    if (id) {
        query = `id=${id}`
    }

    try {
        let res = await request({ type: 'get', url: `receivers/findOne`, query })
        console.log({ res });
        if (res?.data?.data) {
            let data = res?.data?.data

            console.log({ dataaaa: data });
            singleReceiver.value = { ...res?.data?.data }
            return
        }
        return

    } catch (error) {

        console.log({ error });

    }
}
</script>

<template>
    <Head title="Single Receiver">
        <title>
            Single Receiver
        </title>
    </Head>

    <AdminLayout>
        <span></span>
        <div class="ml-4 md:ml-16">
            <div class="mt-16 mb-8 text-xl flex items-center justify-between">
                <div>
                    <span class="text-gray-500">receiver:</span> {{ singleReceiver?.firstname }}
                    {{ singleReceiver?.lastname }}
                </div>
            </div>

            <div class="mb-12 flex flex-col mt-12">
                <div class="flex mt-2">
                    <div class="w-48">First name:</div>
                    <div class="font-semibold">{{ singleReceiver?.firstname }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Last name:</div>
                    <div class="font-semibold">{{ singleReceiver?.lastname }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Email:</div>
                    <div class="font-semibold">{{ singleReceiver?.email }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Phone:</div>
                    <div class="font-semibold">{{ singleReceiver?.phone }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Country:</div>
                    <div class="font-semibold">
                        {{ helpers?.getCountryLabelByCode(singleReceiver?.country_code) }}
                        ({{ singleReceiver?.country_code }})
                    </div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Bank:</div>
                    <div class="font-semibold">{{ singleReceiver?.bank }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Account number:</div>
                    <div class="font-semibold">{{ singleReceiver?.account_number }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Branch number:</div>
                    <div class="font-semibold">{{ singleReceiver?.branch }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Info / Comments:</div>
                    <div class="font-semibold max-w-3xl">{{ singleReceiver?.banking_info }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Bank:</div>
                    <div class="font-semibold">{{ singleReceiver?.receiverBank?.label }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Joined at:</div>
                    <div class="font-semibold">{{ singleReceiver?.created_at }}</div>
                </div>
            </div>

            <SimpleButton @click="router.get(route('app.receivers.page'))">
                Back to receivers list
            </SimpleButton>
        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: 'Singlereceiver'
}
</script>
