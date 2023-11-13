<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";
import Review from "@/Pages/HomePage/partials/Review.vue";
import ArrowLeft from "@/Icons/ArrowLeft.vue";
import ArrowRight from "@/Icons/ArrowRight.vue";
import { onMounted, ref } from "vue";

// Reviews basic slider
const currentPosition = ref(1);
const reviewsCount = 5;
const reviewsElement = ref(null);
const singleReviewElement = ref(null);
const reviewWidth = ref(0);
const currentTranslateValue = ref(0);

const goLeft = () => {
    if (currentPosition.value > 1) {
        // move left
        currentTranslateValue.value =
            currentTranslateValue.value + reviewWidth.value;
        reviewsElement.value.style.transform = `translateX(${currentTranslateValue.value}px)`;
        currentPosition.value--;
    }
};

const goRight = () => {
    if (currentPosition.value < 4) {
        // move right
        currentTranslateValue.value = -(
            reviewWidth.value * currentPosition.value
        );
        reviewsElement.value.style.transform = `translateX(${currentTranslateValue.value}px)`;
        currentPosition.value++;
    }
};

onMounted(() => {
    reviewsElement.value = document.getElementById("reviews");
    singleReviewElement.value = document.getElementById("single-review");
    reviewWidth.value = singleReviewElement.value.clientWidth;
});
</script>

<template>
    <div class="hero-section-five-container inside-container">
        <div class="flex flex-col justify-between">
            <FiftyText class="title" color="dark" variation="heading-2">
                User Love❤️<br />
                Our customers love fifty-fifty, here’s what they’re saying
            </FiftyText>

            <div class="arrow-desktop">
                <ArrowLeft
                    @click="goLeft"
                    :color="currentPosition > 1 ? '#04A949' : ''"
                />
                <ArrowRight
                    @click="goRight"
                    :color="currentPosition < 4 ? '#04A949' : ''"
                />
            </div>
        </div>

        <div class="outer-reviews-container">
            <div class="reviews" id="reviews">
                <Review
                    id="single-review"
                    :numberOfStars="5"
                    :user="{
                        icon: 'images/homePage/avatars/1.png',
                        name: 'Navid Ershad',
                        country: 'Birmingham',
                    }"
                    body="Fifty fifty has changed the game in terms of simplicity, and certainly been a lifesaver for expat living."
                />

                <Review
                    :numberOfStars="5"
                    :user="{
                        icon: 'images/homePage/avatars/2.png',
                        name: 'Jane Yun',
                        country: 'Chicago',
                    }"
                    body="For the first time in my life, I felt like I got real value for a straightforward service"
                />

                <Review
                    :numberOfStars="5"
                    :user="{
                        icon: 'images/homePage/avatars/3.png',
                        name: 'Kamila Joshi',
                        country: 'Canada',
                    }"
                    body="This is the original intent of PayPal for sure. Simple, fast, effective, and almost no fees. Felt like handing money directly to my mum without sweating and at the best rates ever? Cant beat that…"
                />

                <Review
                    :numberOfStars="5"
                    :user="{
                        icon: 'images/homePage/avatars/4.png',
                        name: 'Jimi Juba',
                        country: 'Canada',
                    }"
                    body="IT just makes perfect sense. No drama. Money sent. Money received back home. No ridiculous cost or fees!"
                />
            </div>
        </div>

        <div class="arrows-mobile">
            <ArrowLeft
                @click="goLeft"
                :color="currentPosition > 1 ? '#04A949' : ''"
            />
            <ArrowRight
                @click="goRight"
                :color="currentPosition < 4 ? '#04A949' : ''"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: "HeroSectionFive",
};
</script>
