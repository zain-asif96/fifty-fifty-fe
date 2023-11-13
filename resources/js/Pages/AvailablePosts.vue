<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import ActivePosts from "@/Pages/Posts/partials/ActivePosts.vue";

const props = defineProps({
    posts: {
        type: Array,
        required: true
    },
});


</script>

<template>
    <GuestLayout>
        <Head>
            <title>
                Fifty Fifty | Available Posts
            </title>
        </Head>

        <div class="home-page">
            <ActivePosts :isSinglePage="true" :posts="posts"/>
        </div>


    </GuestLayout>
</template>

