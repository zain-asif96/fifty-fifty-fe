<script setup>
import FlashMessage from "@/Components/Custom/FlashMessage.vue";
import {useNotificationStore} from "@/stores/notification";
import Footer from "@/Layouts/Footer.vue";
import Header from "@/Layouts/Header.vue";

// Notification:
const notificationStore = useNotificationStore();


</script>

<template>
    <div class="isolate bg-white">

        <FlashMessage
            v-if="$page.props.flash.message"
            :message="$page.props.flash.message.content"
            :type="$page.props.flash.message.type"
        />

        <FlashMessage
            v-if="notificationStore.isShown"
            :message="notificationStore.message"
            :type="notificationStore.type"
        />

        <Header/>

        <slot/>

        <Footer/>
    </div>
</template>
<style lang="scss">
@import "resources/scss/main.scss";
</style>
