<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";
import SitePropertyBox from "@/Pages/HomePage/partials/SitePropertyBox.vue";
</script>

<template>
    <div id="our-story" class="hero-section-three-container">
        <FiftyText
            class="limited-title-width"
            color="dark"
            variation="heading-2"
        >
            With us your hard-earned cash goes further!!
        </FiftyText>

        <FiftyText class="mt-10 limited-title-text">
            Maximize your money with fiftyfifty!! We’re the easiest & cheapest
            way to exchange money across borders!
        </FiftyText>

        <div class="site-properties">
            <SitePropertyBox
                description="We’ve removed all the stress connected with trying to exchange currencies yourself."
                iconSrc="images/icons/fast.png"
                title="Fast & Hassle free"
            />

            <SitePropertyBox
                description="We charge the lowest fees possible - 1 unit of whatever currency you exchange and the 
highest exchange rates for your currency."
                iconSrc="images/icons/guaranteed.png"
                title="Lowest Fees & Best Rates"
            />

            <SitePropertyBox
                description="Our service comes with a 100% satisfaction guarantee on your posts with verification and checks all 
the way. We keep the P2P honest!"
                iconSrc="images/icons/secure.png"
                title="Safe & Secure"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: "HeroSectionThree",
};
</script>
