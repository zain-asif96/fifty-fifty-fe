<script setup>
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    navItems: {
        required: true,
    },
});

const geoLocationDetails = usePage().props.geoDetails;
</script>

<template>
    <div class="desktop-navbar fixed" id="fifty-navbar">
        <div class="inside-container">
            <a :href="route('welcome')" class="logo">
                <img
                    alt="Fifty Fifty Logo"
                    src="images/icons/logo/fifty_fifty_logo_updated.svg"
                    class="logo-img"
                />
            </a>

            <div class="nav-items">
                <div
                    v-for="item in navItems"
                    :key="item.title"
                    class="nav-item"
                >
                    <a :href="item.url">{{ item.label }}</a>
                </div>
            </div>

            <div class="action-buttons">
                <NewActionButton
                    v-if="geoLocationDetails.userCanSend"
                    :url="route('user.info.page')"
                    title="Start Posting"
                />
                <NewActionButton
                    v-else
                    :url="route('available.posts.page')"
                    title="Available Posts"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DesktopNavbar",
    methods: {
        fixNavbar() {
            let navbar = document.getElementById("fifty-navbar");
            let navbarMobile = document.getElementById("fifty-navbar-mobile");

            if (window.pageYOffset >= 100) {
                navbar.classList.add("fixed");
                navbarMobile.classList.add("fixed");
            } else {
            }
        },
    },
    mounted() {
        window.onscroll = () => {
            this.fixNavbar();
        };
    },
};
</script>
