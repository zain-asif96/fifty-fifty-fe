<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import Ratings from "@/Components/Design/Ratings.vue";
</script>

<template>
    <div class="hero-section-one inside-container">
        <div class="hero-section-title">
            <FiftyText variation="heading-2">
                Exchanging currencies has never been easier
            </FiftyText>

            <FiftyText class="mt-6" variation="body-l">
                We’re a DIY money exchange platform, allowing you exchange
                dollars for naira and vice versa, getting them sent directly
                where you need it! We help you maximize your hard-earned cash by
                giving you the lowest exchange costs with the best market rates
                for all your transactions
            </FiftyText>

            <!-- <NewActionButton
                :url="route('track.transaction')"
                class="mt-8 w-fit"
                title="Track Transaction"
            /> -->

            <Ratings />
        </div>

        <div class="hero-section-image">
            <img
                alt="People Picture"
                src="images/homePage/hero-section-1.png"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: "HeroSectionOne",
};
</script>
