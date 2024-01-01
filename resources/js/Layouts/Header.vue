<script setup>
import DesktopNavbar from "@/Components/Custom/DesktopNavbar.vue";
import MobileNavbar from "@/Components/Custom/MobileNavbar.vue";
import { redirectionStore } from "@/helpers/redirection";

const navItems = [
    {
        title: "services",
        label: "Services",
        url: "/services",
    },
    {
        title: "track",
        label: "Track Transaction",
        url: "/tt",
    },
    {
        title: "Download App IOS/Android App",
        label: "Download App",
        url: "/#download",
    },
    // {
    //     title: "How it works",
    //     label: "How it works",
    //     url: "/#working",
    // },
    // {
    //     title: "Our Story",
    //     label: "Our Story",
    //     url: "/#our-story",
    // },
    // {
    //     title: "FAQs",
    //     label: "FAQs",
    //     url: "/#faq",
    // },
];

</script>

<template>
    <div>
        <!-- Desktop nav bar -->
        <DesktopNavbar :navItems="navItems" :redirectHandler="redirectionStore" />

        <MobileNavbar :navItems="navItems" :redirectHandler="redirectionStore" />
    </div>
</template>

<script>
export default {
    name: "Header",
};
</script>
