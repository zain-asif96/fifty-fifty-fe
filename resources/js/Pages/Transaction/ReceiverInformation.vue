<script setup>
import {Head} from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ReceiverInfoForm from "@/Pages/Transaction/Partials/forms/ReceiverInfoForm.vue";
import TransactionSteps from "@/Pages/Transaction/Partials/TransactionSteps.vue";
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    user: {
        default: null,
        type: Object
    },
    latestReceivers: {
        default: [],
        type: Array
    },
    banks: {
        default: [],
        type: Array
    }
})

console.log(props.banks);

</script>

<template>
    <GuestLayout>
        <Head title="Fifty-Fifty | Send Money">
            <title>
                Fifty-Fifty | Receiver Information
            </title>
        </Head>

        <div class="transaction-step-wrapper">
            <div class="transaction-step">
                <TransactionSteps current-step="receiver-info" />

                <FiftyText variation="heading-3">
                    Enter Receiver Information
                </FiftyText>

                <transition mode="out-in" name="fade">
                    <ReceiverInfoForm
                        :banks="banks"
                        :latestReceivers="latestReceivers"
                        :user="user"
                    />
                </transition>
            </div>
        </div>
    </GuestLayout>
</template>

<script>
export default {
    name: 'ReceiverInformation'
}
</script>
