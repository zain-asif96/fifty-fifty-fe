<script setup>
import { Head, router } from '@inertiajs/vue3';
import { useNotificationStore } from "@/stores/notification";
import { ref, onMounted } from "vue";
import GuestLayout from '@/Layouts/GuestLayout.vue';
import VerifyCode from "@/Pages/Transaction/Partials/VerifyCode.vue";
import TransactionSteps from "@/Pages/Transaction/Partials/TransactionSteps.vue";
import FiftyText from "@/Components/Design/FiftyText.vue";
import cardInfo from "@/Pages/Transaction/Partials/forms/CardInfo.vue";

import { useAPI } from "@/Composables/useAPI";
const api = useAPI();
const paramSource = ref('');

onMounted(() => {
    // Access the parameter value from the URL
    paramSource.value = new URLSearchParams(window.location.search).get('source');
    console.log('paramSource', paramSource.value);
});
// just code placed here
let showCardInfoDialog = ref(false)
const openCardInfo = () => {
    showCardInfoDialog.value = true;
    cardInfo;
    return { showCardInfoDialog };

}
function closeCardInfoDialog($isFetchData) {
    console.log('$isFetchData', $isFetchData);
    if ($isFetchData == true) {
        notification.notify('Success', 'success');
    }
    showCardInfoDialog.value = false;
    return { showCardInfoDialog };
}

const props = defineProps({
    user: {
        default: null,
        type: Object
    },
})
let currentStep = ref('verify-contacts')
const emailVerified = ref(!!props.user.email_verified_at);

const notificationStore = useNotificationStore();

const continueToPayment = async () => {
    if (emailVerified.value) {
            router.get('/transaction-info')
    } else {
        notificationStore.notify('Please verify your information first', 'error');
    }
}

const verifyUser = () => {
    emailVerified.value = true;
    console.log('paramSource.value',paramSource.value);
    if (paramSource.value != 'direct') {
        currentStep.value = "transaction-info";

        continueToPayment();

    } else {
        currentStep.value = "card-info";
        openCardInfo()

    }

}


</script>

<template>
    <GuestLayout>

        <Head title="Fifty-Fifty | Send Money">
            <title>
                Fifty-Fifty | Send Money
            </title>
        </Head>
        <cardInfo :show="showCardInfoDialog" :user="props.user" v-if="showCardInfoDialog"
            v-on:close="closeCardInfoDialog($event)" />
        <div class="transaction-step-wrapper">
            <div class="transaction-step">

                <TransactionSteps :currentStep="currentStep" />

                <FiftyText variation="heading-3" class="mb-2">
                    Email / Phone Verification
                </FiftyText>

                <FiftyText class="text-center mb-6">
                    Email verification code sent to email: {{ user.email }} and Mobile: {{ user.phone }}
                </FiftyText>

                <Transition mode="out-in" name="fade">
                    <VerifyCode :user="user" @verified="verifyUser" />
                </Transition>
            </div>
        </div>
    </GuestLayout>
</template>
<script>
export default {
    name: 'VerifyContacts'
}
</script>
