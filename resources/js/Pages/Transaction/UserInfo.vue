<script>
export default {
    name: 'Main'
}
</script>
<script setup>
import {Head} from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import SenderAndPayementInfoForm from "@/Pages/Transaction/Partials/forms/SenderAndPayementInfoForm.vue";
// import PaymentInformationForm from "@/Pages/Transaction/Partials/forms/PaymentInformationForm.vue";
import {onMounted} from "vue";
import FiftyText from "@/Components/Design/FiftyText.vue";
import TransactionSteps from "@/Pages/Transaction/Partials/TransactionSteps.vue";


onMounted(() => {
    window.sessionStorage.setItem('resend-timer', 60);
})
const props = defineProps({
    transactionId: {
        required: false,
        type: String
    },
    user: {
        // required: true,
        default: null,
        type: Object
    },
    commissions: {
        // required: true,
        default: null,
        type: Object
    },
    receivingCountries: {
        required: true,
        default: [],
        type: Array
    }
})
</script>

<template>
    <GuestLayout>
        <Head title="Fifty-Fifty | Send Money">
            <title>
                Fifty-Fifty | Send Money
            </title>
        </Head>

        <div class="transaction-step-wrapper">
            <div class="transaction-step">
                <TransactionSteps />

                <FiftyText variation="heading-3">
                    Enter Sender Information
                </FiftyText>

                <Transition mode="out-in" name="fade">
                    <SenderAndPayementInfoForm :user="props.user" :commissions="props.commissions" :receivingCountries="props.receivingCountries" :transactionId="props.transactionId" />
                </Transition>

            </div>
        </div>
    </GuestLayout>
</template>
