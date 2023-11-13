<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, router} from '@inertiajs/vue3';
import {useHelpers} from "@/Composables/useHelpers";
import SimpleButton from "@/Components/Custom/SimpleButton.vue";

const props = defineProps({
    user: {
        required: true,
        type: Object
    }
})


const helpers = useHelpers()

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
                    <span class="text-gray-500">User:</span> {{ props.user.first_name }} {{ props.user.last_name }}
                </div>
            </div>

            <div class="flex flex-col mt-12 mb-12">
                <div class="flex mt-2">
                    <div class="w-32">First name:</div>
                    <div class="font-semibold">{{ props.user.first_name }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-32">Last name:</div>
                    <div class="font-semibold">{{ props.user.last_name }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-32">Email:</div>
                    <div class="font-semibold">{{ props.user.email }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-32">Phone:</div>
                    <div class="font-semibold">{{ props.user.phone }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-32">Country:</div>
                    <div class="font-semibold">{{ helpers.getCountryLabelByCode(props.user.country) }}
                        ({{ props.user.country }})
                    </div>
                </div>

                <div class="flex mt-2">
                    <div class="w-32">IP Address:</div>
                    <div class="font-semibold">{{ props.user.ip_address }}</div>
                </div>

                <div class="flex mt-2">
                    <div class="w-32">Joined at:</div>
                    <div class="font-semibold">{{ props.user.created_at }}</div>
                </div>
            </div>


            <SimpleButton @click="router.get(route('users.page'))">
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
