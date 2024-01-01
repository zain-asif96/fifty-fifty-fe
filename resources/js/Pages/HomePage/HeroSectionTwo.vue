<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";
import GetMoneySection from "@/Pages/HomePage/partials/GetMoneySection.vue";
import { redirectionStore } from "@/helpers/redirection";

</script>

<template>
    <div class="hero-section-two-container">
        <div class="inner-wrap-two">
            <FiftyText class="limited-title-width" color="dark" variation="heading-2">
                Peer Swap to US/Canada from Nigeria & vice versa
            </FiftyText>

            <FiftyText class="mt-10 limited-title-text">
                Instantly! hassle-free! and with little to no fees! Use our website
                or app to connect with a peer and instantly exchange money between
                US & Nigeria using direct bank deposits!
            </FiftyText>
        </div>

        <GetMoneySection :redirectHandler="redirectionStore" />
    </div>
</template>

<script>
export default {
    name: "HeroSectionTwo",
};
</script>
