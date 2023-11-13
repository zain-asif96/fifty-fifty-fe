<script setup>

import FiftyText from "@/Components/Design/FiftyText.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
</script>

<template>

    <div class="hero-section-nine-container inside-container">
        <div class="info">
            <FiftyText color="dark" variation="heading-2">
                Get Set Up & Save Money <br/>
                On Your Next Transfer
            </FiftyText>

            <NewActionButton :url="route('user.info.page')" class="w-fit" title="Get Started"/>
        </div>

        <div class="image-side">
            <img alt="home page" src="images/homePage/hero-section-4.png">
        </div>
    </div>

</template>

<script>

export default {
    name: "HeroSectionNine"
}
</script>
