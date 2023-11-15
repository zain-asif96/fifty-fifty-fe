<script setup>
import { ref } from "vue";
import SidebarElement from "@/Pages/Admin/partials/SidebarElement.vue";
import CloseIcon from "@/Icons/CloseIcon.vue";

const isOpened = ref(false);

const toggleSidebar = () => {
    isOpened.value = !isOpened.value;
}

</script>


<template>
    <button aria-controls="default-sidebar"
        class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" type="button" @click="toggleSidebar">
        <span class="sr-only">Open sidebar</span>
        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
                fill-rule="evenodd"></path>
        </svg>
    </button>

    <aside id="default-sidebar" :class="{ '-translate-x-full': !isOpened }" aria-label="Sidebar"
        class="fixed md:relative top-0 left-0 z-40 w-64 h-screen transition-transform sm:translate-x-0">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
            <button
                class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                @click="toggleSidebar">
                <CloseIcon />
            </button>
            <ul class="space-y-2">
                <SidebarElement icon="dashboard" route-name="app.admin.panel.page" title="admin panel" />

                <SidebarElement :active-routes="['app.users.page', 'app.single.user.page']" icon="users"
                    route-name="app.users.page" title="users" />

                <SidebarElement icon="admins" route-name="app.admins.page" title="admins" />

                <SidebarElement :active-routes="['app.transactions.page', 'app.payment.intent.page']" icon="transactions"
                    route-name="app.transactions.page" title="transactions" />

                <SidebarElement :active-routes="['app.posts.page']" icon="posts" route-name="app.posts.page"
                    title="posts" />

                <SidebarElement :active-routes="['app.receivers.page', 'app.single.receiver.page']" icon="receivers"
                    route-name="app.receivers.page" title="receivers" />

                <SidebarElement icon="banks" route-name="banks.page" title="banks" />

                <SidebarElement icon="countries" route-name="countries.page" title="countries" />

                <SidebarElement icon="currencies" route-name="currencies.page" title="currencies" />

                <SidebarElement icon="timer" route-name="time.page" title="Global Variables" />
                <SidebarElement icon="money" route-name="commission.page" title="Commission" />
            </ul>
        </div>
    </aside>
</template>


<script>
export default {
    name: 'CustomSidebar'
}
</script>
