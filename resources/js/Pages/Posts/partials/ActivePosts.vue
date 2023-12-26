<script setup>
import PostItem from "@/Pages/Posts/partials/PostItem.vue";
import FiftyText from "@/Components/Design/FiftyText.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import {usePage} from "@inertiajs/vue3";
import Modal from "@/Components/Custom/Modal.vue";

import { onMounted, ref } from "vue";

const props = defineProps({
    posts: {
        type: Array,
        default: []
    },
    isSinglePage: Boolean
});

const geoLocationDetails = usePage().props.geoDetails;

const isModalOpened = ref(false);

const closeModal = () => {
    isModalOpened.value = false;
    localStorage.setItem('modalClosed','true')
}

const openModal = () => {
    if ( localStorage.getItem('modalClosed') === "true") return;
    isModalOpened.value = true;
}


onMounted(()=>{
    openModal()
})

</script>

<template>
    <div :class="{'single-page': isSinglePage || !geoLocationDetails.userCanSend}" class="active-posts-container">
        <div class="content-container inside-container">
            <FiftyText color="dark" variation="heading-3">
                Current active posts in {{ geoLocationDetails.country.label }}
            </FiftyText>

            <FiftyText v-if="props.posts.length === 0" color="dark" variation="body-xl">
                There are no active posts now in your country.
            </FiftyText>

            <div class="post-items">
                <PostItem v-for="post in props.posts" :key="post.id" :post="post"/>
            </div>

            <NewActionButton
                v-if="!isSinglePage"
                :url="route('available.posts.page')" class="w-fit"
                title="View All Posts"
            />
        </div>
        <div>
            <Modal width="wide" :close="closeModal" :isOpen="isModalOpened" header="Introduction">
             

                <template #content>
                    <div class="p-6">
                     <video class="w-full" src="images/intro.mp4" controls></video>
                    </div>

                </template>

            </Modal>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ActivePosts'
}
</script>
