<script setup>
import {onMounted, ref} from "vue";
import Spinner from "@/Components/Custom/Spinner.vue";
import {useNotificationStore} from "@/stores/notification";
import {useAPI} from "@/Composables/useAPI";
import {router} from "@inertiajs/vue3";
import {useHelpers} from "@/Composables/useHelpers";
import NewTextInput from "@/Components/Design/NewTextInput.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue"

const props = defineProps({
    paymentIntent: {
        default: null,
        type: Object
    },
    stripeConfig: {
        default: null,
        type: Object
    }
})

const emit = defineEmits(['stepChanged'])
const helpers = useHelpers();
const api = useAPI();
const stripe = Stripe(props.stripeConfig.public_key);
const notification = useNotificationStore()
const isLoading = ref(false);


let elements = null;
let options = null;
let paymentElement = null;

const makePayment = async (event) => {
    event.preventDefault();

    isLoading.value = true;

    const {error} = await stripe.confirmPayment({
        elements,
        confirmParams: {
            return_url: props.stripeConfig.redirect_url
        },
    });

    isLoading.value = false;

    if (error) {
        notification.notify(error.message, 'error');
    } else {
        console.log('Success, and redirect to server endpoint');
    }
}

const initializeStripeElements = () => {
    options = {
        clientSecret: props.paymentIntent.client_secret,
        appearance: {},
    };
    elements = stripe.elements(options);
    paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');
}


onMounted(() => {
    initializeStripeElements();
})


const goBack = () => {
    const paramCountry = helpers.getURLParam('country');
    const paymentIntentID = helpers.getURLParam('payment-reference-identification');
    router.get('/receiver-info?payment-reference-identification=' + paymentIntentID + '&country=' + paramCountry);
}

</script>
<template>
    <form id="payment-form" class="payment-form-wrapper">
        <div id="payment-element"></div>

        <div class="action-buttons">
            <NewActionButton
                :reversed="true"
                title="Back"
                @click="goBack"
            />

            <NewActionButton
                @click="makePayment"
                :isLoading="isLoading"
                title="Authorize Card"
            />
        </div>
    </form>
</template>

<script>
export default {
    name: 'CardDetailsForm'
}
</script>
