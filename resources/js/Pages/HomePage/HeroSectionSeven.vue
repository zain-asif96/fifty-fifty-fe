<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    direction: String,
});
</script>

<template>
    <div
        id="download"
        :class="{ 'reverse-section': direction === 'reverse' }"
        class="hero-section-seven-container inside-container"
    >
        <div class="image-side">
            <img alt="home page" src="images/homePage/herosection3_updated.png" />
        </div>

        <div class="flex flex-col info">
            <FiftyText color="dark" variation="heading-2">
                Try Our Secure & Easy-to-use Money Transfer App
            </FiftyText>

            <FiftyText class="mt-8 mb-12">
                Send money on the go with the fiftyfifty app. Check for great
                rates, enjoy faster repeat transfers with a few taps, and find
                the closest payout and send locations from anywhere.
            </FiftyText>

            <div class="apps-icons">
                <img
                    alt="Google Icon"
                    class="google"
                    src="images/icons/apps/google-play-badge.png"
                />
                <img
                    alt="Apple Store"
                    src="images/icons/apps/apple-store.svg"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HeroSectionSeven",
};
</script>
