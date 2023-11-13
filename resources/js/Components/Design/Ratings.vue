<script setup>

import FiftyText from "@/Components/Design/FiftyText.vue";

const avatars = [
    {
        key: 1,
        src: 'images/homePage/avatars/1.png'
    },
    {
        key: 2,
        src: 'images/homePage/avatars/2.png'
    },
    {
        key: 3,
        src: 'images/homePage/avatars/3.png'
    },
    {
        key: 4,
        src: 'images/homePage/avatars/4.png'
    },

];

</script>


<template>

    <div class="ratings-container">
        <div class="avatars">
            <img v-for="avatar in avatars" :key="avatar.key" :src="avatar.src" alt="" class="avatar">
            <div class="rating-number">
                +4k
            </div>
        </div>

        <div class="rating-text">
            <div>
                <FiftyText class="flex items-center gap-1" color="dark" variation="body-bold">
                    Ratings
                    <img alt="star icon" src="images/icons/star.png">
                    5.0
                </FiftyText>
            </div>
            <div>
                <FiftyText variation="body-l">
                    Trusted From Worldwide
                </FiftyText>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: 'Ratings'
}
</script>

<style lang="scss">
</style>
