<script setup>
import {Link} from '@inertiajs/vue3'
import DashboardIcon from "@/Icons/DashboardIcon.vue";
import AdminsIcon from "@/Icons/AdminsIcon.vue";
import BanksIcon from "@/Icons/BanksIcon.vue";
import CountriesIcon from "@/Icons/CountriesIcon.vue";
import PostsIcon from "@/Icons/PostsIcon.vue";
import CurrenciesIcon from "@/Icons/CurrenciesIcon.vue";
import TransactionsIcon from "@/Icons/TransactionsIcon.vue";
import UsersIcon from "@/Icons/UsersIcon.vue";
import ReceiversIcon from "@/Icons/ReceiversIcon.vue";
import TimerIcon from "@/Icons/TimerIcon.vue";
import MoneyIcon from "@/Icons/MoneyIcon.vue";

import {onMounted, ref} from "vue";

const props = defineProps({
    title: String,
    routeName: String,
    activeRoutes: {
        type: Array,
        default: []
    },
    icon: String
})

const icons = {
    'dashboard': DashboardIcon,
    'users': UsersIcon,
    'admins': AdminsIcon,
    'receivers': ReceiversIcon,
    'banks': BanksIcon,
    'countries': CountriesIcon,
    'posts': PostsIcon,
    'transactions': TransactionsIcon,
    'currencies': CurrenciesIcon,
    'timer': TimerIcon,
    'money':MoneyIcon,

}

const isRouteActive = ref(false)

onMounted(() => {
    const currentRoute = route().current();
    isRouteActive.value = props.activeRoutes.includes(currentRoute) || props.routeName === currentRoute;
})

</script>

<template>
    <li>
        <Link
            :class="{'bg-gray-200': isRouteActive}"
            :href="route(routeName)"
            class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

            <Component :is="icons[icon]"/>

            <span class="ml-3 capitalize">{{ title }}</span>
        </Link>
    </li>
</template>

<script>
export default {
    name: 'SidebarElement'
}
</script>
<style scoped>
svg{
    font-size: 12px;
    width: 26px;
    color: grey;
}
</style>
