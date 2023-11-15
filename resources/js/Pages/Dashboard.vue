<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { userUserStore } from '@/stores/user';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted } from "vue";


const $userStore = userUserStore();

onMounted(() => {
    console.log(usePage().props.auth.user)
    console.log(props.authdata, "PROPSSSSS", $userStore.getUserApp);
    if (props?.authdata) {
        $userStore.setUserApp(props?.authdata)
    }
})

const props = defineProps({
    authdata: {
        required: true,
        type: Object
    }
})
</script>

<template>
    <Head title="Dashboard">
        <title>
            Dashboard
        </title>
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">Welcome {{
                        $page.props.auth.user.first_name
                    }} {{ $page.props.auth.user.last_name }} !
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
