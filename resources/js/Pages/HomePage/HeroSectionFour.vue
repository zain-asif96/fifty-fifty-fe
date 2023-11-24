<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";
import WorkingStep from "@/Pages/HomePage/partials/WorkingStep.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
</script>

<template>
    <div id="working" class="hero-section-four-container">
        <FiftyText
            class="limited-title-width"
            color="dark"
            variation="heading-2"
        >
            How It Works
        </FiftyText>

        <FiftyText class="mt-10 limited-title-text">
            Exchanging money is as easy as 1,2,3,4! Have the best market value
            in your pocket. With no hidden fees, every transaction to your
            friends and family goes further. Check the most up-to-date rates at
            any time for easy sending. With our initial launch on Canada, US and Nigeria, our target is 120 countries within the next 6 months.
            <!-- More than 120 countries are soon to be
            updated. -->
        </FiftyText>

        <div class="working-steps">
            <WorkingStep
                description="Confirm the rates for the currency you want to exchange."
                number="01"
                title="Confirm Best rates"
            />

            <WorkingStep
                description="No Register & enter your transaction details."
                number="02"
                title="Details"
            />

            <WorkingStep
                description="2-factor IR reviews your identity & post transaction."
                number="03"
                title="Verification"
            />

            <WorkingStep
                description="Get paired with a partner, make payments. With updates via SMS and email."
                number="04"
                title="Peer & Track"
            />
        </div>

        <NewActionButton
            :url="route('user.info.page')"
            class="w-fit"
            title="Get Started"
        />
    </div>
</template>

<script>
export default {
    name: "HeroSectionFour",
};
</script>
