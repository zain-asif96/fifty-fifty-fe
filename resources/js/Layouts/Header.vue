<script setup>
import DesktopNavbar from "@/Components/Custom/DesktopNavbar.vue";
import MobileNavbar from "@/Components/Custom/MobileNavbar.vue";

const navItems = [
    {
        title: "services",
        label: "Services",
        url: "/services",
    },
    {
        title: "track",
        label: "Track Transaction",
        url: "/track-transaction",
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
        <DesktopNavbar :navItems="navItems" />

        <MobileNavbar :navItems="navItems" />
    </div>
</template>

<script>
export default {
    name: "Header",
};
</script>
