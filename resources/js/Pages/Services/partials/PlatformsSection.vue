<script setup>

import FiftyText from "@/Components/Design/FiftyText.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";

const props = defineProps({
    text: String,
    title: String,
    direction: String,
})

const platforms = [
    {
        title: "Web Application",
        description: "You can use our website from any modern browser on your desktop or laptop device.",
        icon: "images/icons/web-icon.png"
    },
    {
        title: "Android Application",
        description: "You can download our application from the Play Store.",
        icon: "images/icons/android-icon.png"
    },
    {
        title: "iOS Application",
        description: "You can download our application from the Apple Store.",
        icon: "images/icons/apple-icon.png"
    },
];

</script>


<template>
    <div class="services-info-section platforms-section inside-container">
        <div class="content-wrapper">
            <FiftyText class="title" variation="heading-2">
                {{ props.title }}
            </FiftyText>

            <FiftyText class="body" variation="body-l">
                <p v-html="props.text"></p>
            </FiftyText>

            <div class="platforms-container">
                <div class="platforms">
                    <div v-for="platform in platforms" :key="platform.title" class="platform">
                        <div class="platform-icon-container">
                            <img :src="platform.icon" alt="platform icon">
                        </div>

                        <div class="platform-body">
                            <FiftyText color="dark" variation="body-xl">
                                {{ platform.title }}
                            </FiftyText>

                            <FiftyText>
                                {{ platform.description }}
                            </FiftyText>
                        </div>
                    </div>
                </div>
            </div>

            <NewActionButton :url="route('user.info.page')" class="w-fit" title="Get Started"/>
        </div>

        <div class="person-photo-section">
            <div class="image-container">
                <img alt="person" class="person" src="images/services/services-3-person.png">
                <img alt="person" class="person-background" src="images/services/services-person-bg.png">
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: 'PlatformsSection'
}
</script>
