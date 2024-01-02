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
import { redirectionStore } from "@/helpers/redirection";

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
// console.log({ cccc: props?.supportedCountries });

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

            <!-- <TransactionBox
                v-if="geoLocationDetails.userCanSend"
                    :receivingCountries="receivingCountries"
                /> -->
            <!-- <TransactionBox /> -->

            <HeroSectionTwo />

            <HeroSectionThree />

            <HeroSectionFour />

            <HeroSectionFive />

            <HeroSectionSix :supportedCountries="supportedCountries" />

            <HeroSectionSeven />

            <HeroSectionEight />

            <HeroSectionNine :redirectHandler="redirectionStore" />
        </div>
    </GuestLayout>
</template>
<script>
export default {
    created() {
        const currentUrl = window.location.href;
        // Check if the current URL matches the pattern
        if (currentUrl.includes("?app=download")) {
            // Extract the value of the 'app' query parameter
            const url = new URL(currentUrl);
            const appQueryParam = url.searchParams.get("app");
            // Perform redirection based on the platform
            this.redirectToAppStore(appQueryParam);
        }
    },
    methods: {
        redirectToAppStore(appName) {
            // Replace the condition with the actual app names and corresponding app store URLs
            if (appName === "download") {
                // Redirect to the respective app store based on the user's device
                const isiOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
                const isAndroid = /Android/.test(navigator.userAgent);
                if (isiOS) {
                    window.location.href =
                        "https://apps.apple.com/us/app/uber-request-a-ride/id368677368";
                } else if (isAndroid) {
                    // Adjust the Android package name and URL
                    window.location.href =
                        "https://play.google.com/store/apps/details?id=com.ubercab";
                } else {
                    // Handle other platforms or provide a generic message
                    window.location.href =
                        "https://test.fiftyfifty.io/#download";
                }
            }
        },
    },
};
</script>
