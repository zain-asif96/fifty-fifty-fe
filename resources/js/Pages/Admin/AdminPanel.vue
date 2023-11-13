<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head} from '@inertiajs/vue3';

</script>

<template>
    <Head title="Admin panel">
        <title>
            Admin panel
        </title>
    </Head>

    <AdminLayout>
        <div class="mt-16 ml-16 text-xl">
            Welcome to admin panel..
        </div>
    </AdminLayout>
</template>

<script>

export default {
    name: 'AdminPanel'
}
</script>
