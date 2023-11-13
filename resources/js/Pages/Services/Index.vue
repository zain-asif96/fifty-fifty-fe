<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Head} from '@inertiajs/vue3';
import InfoSection from "@/Pages/Services/partials/InfoSection.vue";
import HeroSectionTwo from "@/Pages/HomePage/HeroSectionTwo.vue";
import HeroSectionThree from "@/Pages/HomePage/HeroSectionThree.vue";
import PlatformsSection from "@/Pages/Services/partials/PlatformsSection.vue";
import HeroSectionSeven from "@/Pages/HomePage/HeroSectionSeven.vue";
import HeroSectionSix from "@/Pages/HomePage/HeroSectionSix.vue";

const props = defineProps({
    supportedCountries: {
        required: true,
        default: [],
        type: Array
    }
});

</script>

<template>
    <GuestLayout>

        <Head>
            <title>
                Fifty Fifty | Services
            </title>
        </Head>

        <div class="services-page">

            <HeroSectionTwo/>

            <InfoSection
                direction="direct"
                image="images/services/services-1-cheap.png"
                text="50-50 has made the globe flat with Peer-2-Peer money transfer.
                 We're upfront about our ridiculously low fees and best market driven exchange rates.
                  Send mon ey instantly to friends, family & business partner from our app or web portal with direct bank deposits.
                  Pick the transfer methods that works best. Check our price calculator before you send money."
                title="How we keep it cheap"
            />

            <InfoSection
                direction="reverse"
                image="images/services/services-2-different.png"
                text="Best Market Rates globally. Loved ones receive the best value for the money sent!
0% transfer/ fee for the receiver. less than 0.1% transaction fee for sender
Safe & guaranteed transactions: Dedicated Servers with Fraud detection
Secure! Secure! Secure! Money back guaranteed!
Local-Local payment. Save Big on all transfers!
Transparent Process: Track your payment status.
Fast: Minutes-Few Hours transaction time.
Multilevel layer authentications. Safeguarded with a partner bank.
Data protection.
"
                title="We are different!"/>

            <HeroSectionThree/>

            <PlatformsSection
                text="50-50 has made the globe flat with Peer-2-Peer money transfer. We're upfront about our ridiculously low fees and best market driven exchange rates. Send mon ey instantly to friends, family & business partner from our app or web portal with direct bank deposits. Pick the transfer methods that works best. Check our price calculator before you send."
                title="Available On All The
Platforms You Use."
            />

            <HeroSectionSeven direction="reverse"/>

            <HeroSectionSix :supportedCountries="supportedCountries"/>

        </div>

    </GuestLayout>


</template>
