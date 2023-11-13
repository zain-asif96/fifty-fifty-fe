<script setup>
import {Head} from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PaymentInformationForm from "@/Pages/Transaction/Partials/forms/PaymentInformationForm.vue";
import TransactionSteps from "@/Pages/Transaction/Partials/TransactionSteps.vue";
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    user: {
        required: true,
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
                Fifty-Fifty | Make Payment
            </title>
        </Head>

        <div class="transaction-step-wrapper">
            <div class="transaction-step">
                <TransactionSteps current-step="transaction-info" />

                <FiftyText variation="heading-3">
                    Transaction information
                </FiftyText>

                <transition mode="out-in" name="fade">
                    <PaymentInformationForm :receivingCountries="receivingCountries" :user="user"/>
                </transition>
            </div>
        </div>
    </GuestLayout>
</template>

<script>
export default {
    name: 'PaymentInformation'
}
</script>
