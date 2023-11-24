<script setup>
import { ref } from "vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";

const props = defineProps({
    navItems: {
        required: true,
    },
});

const menu = ref(false);

let toggleMenu = () => {
    menu.value = !menu.value;
};
</script>

<template>
    <div class="mobile-navbar fixed" id="fifty-navbar-mobile">
        <div :class="{ active: !menu }" class="header">
            <a class="logo" href="/">
                <img
                    alt="Fifty Fifty Logo"
                    src="images/icons/logo/fifty_fifty_logo.svg"
                    class="logo-img"
                />
            </a>
            <div class="open-icon" @click="toggleMenu">
                <img alt="open icon" src="images/icons/open-icon.svg" />
            </div>
        </div>

        <div :class="{ active: menu }" class="menu-body">
            <div class="head">
                <a href="/" class="logo">
                    <img
                        alt="Fifty Fifty Logo"
                        src="images/icons/logo/fifty_fifty_logo.svg"
                        class="logo-img"
                    />
                </a>
                <div class="close-icon" @click="toggleMenu">
                    <img alt="close icon" src="images/icons/close-icon.svg" />
                </div>
            </div>
            <div class="menu-items">
                <div
                    v-for="item in navItems"
                    :key="item.title"
                    class="menu-item"
                >
                    <a :href="item.url" @click="toggleMenu">{{ item.label }}</a>
                </div>
            </div>

            <div class="action-button-wrapper">
                <NewActionButton
                    :url="route('user.info.page')"
                    class="w-fit"
                    title="Start currency swap"

                    />
                    <!-- title="Start Posting" -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MobileNavbar",
};
</script>
