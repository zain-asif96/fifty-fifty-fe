<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, router} from '@inertiajs/vue3';
import {useHelpers} from "@/Composables/useHelpers";
import SimpleButton from "@/Components/Custom/SimpleButton.vue";

const props = defineProps({
    receiver: {
        required: true,
        type: Object
    }
})


const helpers = useHelpers()

</script>

<template>

    <Head title="Single Receiver">
        <title>
            Single Receiver
        </title>
    </Head>

    <AdminLayout>
        <div class="ml-4 md:ml-16">
            <div class="mt-16 mb-8 text-xl flex items-center justify-between">
                <div>
                    <span class="text-gray-500">receiver:</span> {{ props.receiver.first_name }}
                    {{ props.receiver.last_name }}
                </div>
            </div>

            <div class="mb-12 flex flex-col mt-12">
                <div class="flex mt-2">
                    <div class="w-48">First name:</div>
                    <div class="font-semibold">{{ props.receiver.first_name }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Last name:</div>
                    <div class="font-semibold">{{ props.receiver.last_name }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Email:</div>
                    <div class="font-semibold">{{ props.receiver.email }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Phone:</div>
                    <div class="font-semibold">{{ props.receiver.phone }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Country:</div>
                    <div class="font-semibold">{{ helpers.getCountryLabelByCode(props.receiver.country) }}
                        ({{ props.receiver.country }})
                    </div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Bank:</div>
                    <div class="font-semibold">{{ props.receiver.bank }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Account number:</div>
                    <div class="font-semibold">{{ props.receiver.account_number }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Branch number:</div>
                    <div class="font-semibold">{{ props.receiver.branch_number }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Info / Comments:</div>
                    <div class="font-semibold max-w-3xl">{{ props.receiver.banking_info }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Bank:</div>
                    <div class="font-semibold">{{ props.receiver.bank }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-48">Joined at:</div>
                    <div class="font-semibold">{{ props.receiver.created_at }}</div>
                </div>
            </div>

            <SimpleButton @click="router.get(route('receivers.page'))">
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
