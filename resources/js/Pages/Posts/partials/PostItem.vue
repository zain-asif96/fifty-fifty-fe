<script setup>
import { Link } from "@inertiajs/vue3";
import { useHelpers } from "@/Composables/useHelpers";
import { onMounted, reactive } from "vue";
import { currencies_countries } from "@/helpers/currencies_countries";
import FiftyText from "@/Components/Design/FiftyText.vue";

const helpers = useHelpers();

const props = defineProps({
    post: {
        type: Object,
    },
});

const postData = reactive({});

onMounted(() => {
    postData.transactionID = props.post.transaction.id;
    postData.senderName = props.post.transaction.user.first_name;
    postData.senderCountry = helpers.getCountryLabelByCode(
        props.post.transaction.user.country
    );
    postData.amount = parseFloat(
        (props.post.transaction.payment_intent.amount / 100).toFixed(2)
    );
    postData.currency = props.post.transaction.payment_intent.currency;
    postData.receiverCountry = helpers.getCountryLabelByCode(
        props.post.transaction.receiver.country
    );
    postData.amountInReceiverCurrency = parseFloat(
        (
            props.post.transaction.payment_intent.amount_in_receiver_currency /
            100
        ).toFixed(2)
    );
    postData.receiverCurrency =
        currencies_countries[props.post.transaction.receiver.country];
});
</script>

<template>
    <div class="post-item">
        <div :class="{ 'opacity-40': post.status === 'on_hold' }">
            <FiftyText color="dark" variation="body-xl">
                {{ postData.receiverCountry }} to {{ postData.senderCountry }}
            </FiftyText>

            <div class="flex items-center gap-2 price_item">
                <FiftyText color="dark" variation="body-xxl">
                    <b class="uppercase">
                        {{ postData.amount }} {{ postData.currency }}</b
                    >
                </FiftyText>

                <FiftyText v-if="postData.amountInReceiverCurrency > 0">
                    ({{ postData.amountInReceiverCurrency }}
                    {{ postData.receiverCurrency }})
                </FiftyText>
            </div>

            <FiftyText class="mt-5">
                {{ postData.senderName }} from
                {{ postData.senderCountry }} wants to send {{ postData.amount }}
                <span class="ml-1 uppercase">{{ postData.currency }}</span>
                to {{ postData.receiverCountry }}, would you like to handle this
                transaction ?
            </FiftyText>

            <Link
                v-if="post.status === 'available'"
                :href="`/handle-transaction?source=${postData.transactionID}`"
                class="post-action-button mt-7"
            >
                Complete Transaction

                <svg
                    aria-hidden="true"
                    class="w-4 h-4 ml-2 -mr-1"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        clip-rule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        fill-rule="evenodd"
                    ></path>
                </svg>
            </Link>

            <div></div>
        </div>

        <p
            v-if="post.status === 'on_hold'"
            class="font-semibold mt-6 text-red-700"
        >
            Post is currently on hold, please check on later for updates.
        </p>
    </div>
</template>

<script>
export default {
    name: "PostItem",
};
</script>

<style lang="scss" scoped>
.post-item {
    width: 100%;
    max-width: 250px;
    background: #ffffff;
    box-shadow: 0px 4px 80px rgba(0, 3, 48, 0.08);
    border-radius: 16px;
    padding: 24px;

    display: flex;
    flex-direction: column;
    text-align: left;

    .post-action-button {
        font-family: "General Sans", serif;
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 160%;
        text-align: center;
        color: #616274;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        width: fit-content;
        border-bottom: 1px solid #616274;

        &:hover {
            transform: scale(1.03);
            color: #04a949;
            border-bottom: 1px solid #04a949;
        }
    }
}

.price_item{
    flex-direction: column !important;
    align-items: flex-start!important;
}


</style>
