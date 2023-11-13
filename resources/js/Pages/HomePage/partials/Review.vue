<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    numberOfStars: Number,
    body: String,
    user: Object,
});
</script>

<template>
    <div class="review-container">
        <div class="stars">
            <img :key="i" alt="comma" src="images/icons/comma.png" />
        </div>
        <FiftyText class="mb-8 mt-8">
            {{ body }}
        </FiftyText>
        <div class="user">
            <img :src="user.icon" alt="user-photo" />

            <div class="info">
                <FiftyText color="dark" variation="body-l">
                    {{ user.name }}
                </FiftyText>
                <FiftyText class="country">
                    {{ user.country }}
                </FiftyText>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Review",
};
</script>
