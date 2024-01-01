<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";

const props = defineProps({
    redirectHandler: {
        type: Function,
        default: () => { }

    },
});
</script>

<template>
    <div class="get-money-section-cont">

        <div class="content-container">
            <div class="inner-container">

                <FiftyText color="dark" variation="heading-3">
                    Peer to peer money exchange the way it was meant to be!
                </FiftyText>

            </div>
            <div class="inner-cont-bg">
                <div class="inner-cont-info">
                    <FiftyText class="body-text">
                        Our dream is for people to live and work anywhere seamlessly.
                        That means money without borders: moving it instantly,
                        transparently, conveniently, and eventually for free.
                    </FiftyText>

                    <NewActionButton @click="redirectHandler" class="w-fit money-action-button"
                        title="Start currency swap" />
                </div>
            </div>

            <div class="inner-cont-resp"></div>

        </div>
    </div>
</template>

<script>
export default {
    name: "GetMoneySection",
};
</script>
