<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import ActivePosts from "@/Pages/Posts/partials/ActivePosts.vue";
import HeroSectionOne from "@/Pages/HomePage/HeroSectionOne.vue";
import TransactionBox from "@/Pages/HomePage/TransactionBox.vue";
import HeroSectionTwo from "@/Pages/HomePage/HeroSectionTwo.vue";
import HeroSectionThree from "@/Pages/HomePage/HeroSectionThree.vue";
import HeroSectionFour from "@/Pages/HomePage/HeroSectionFour.vue";
import HeroSectionFive from "@/Pages/HomePage/HeroSectionFive.vue";
import HeroSectionSix from "@/Pages/HomePage/HeroSectionSix.vue";
import HeroSectionSeven from "@/Pages/HomePage/HeroSectionSeven.vue";
import HeroSectionEight from "@/Pages/HomePage/HeroSectionEight.vue";
import HeroSectionNine from "@/Pages/HomePage/HeroSectionNine.vue";
import CurrencyExchangeBar from "@/Pages/HomePage/CurrencyExchangeBar.vue";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    receivingCountries: {
        required: true,
        default: [],
        type: Array,
    },
    supportedCountries: {
        required: true,
        default: [],
        type: Array,
    },
    posts: {
        type: Array,
        default: [],
    },
    rates: {
        type: Array,
        default: [],
    },
});

// Geo Location:
const geoLocationDetails = usePage().props.geoDetails;
console.log({cccc:props?.supportedCountries});
</script>

<template>
    <GuestLayout>
        <Head>
            <title>Fifty Fifty | Homepage</title>
        </Head>

        <div class="home-page">
            <CurrencyExchangeBar :rates="rates" />

            <ActivePosts :posts="posts" />

            <HeroSectionOne />

            <TransactionBox
            v-if="geoLocationDetails.userCanSend"
                :receivingCountries="receivingCountries"
            />

            <HeroSectionTwo />

            <HeroSectionThree />

            <HeroSectionFour />

            <HeroSectionFive />

            <HeroSectionSix :supportedCountries="supportedCountries" />

            <HeroSectionSeven />

            <HeroSectionEight />

            <HeroSectionNine />
        </div>
    </GuestLayout>
</template>
