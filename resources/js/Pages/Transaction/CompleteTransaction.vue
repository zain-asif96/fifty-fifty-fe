<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import TransactionSteps from "@/Pages/Transaction/Partials/TransactionSteps.vue";
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    transactionId: {
        type:String,
        default: null
    }
})
console.log('transactionId',props.transactionId);

</script>

<template>
    <GuestLayout>

        <Head title="Fifty-Fifty | Send Money">
            <title>
                Fifty-Fifty |Transaction Completed !
            </title>
        </Head>

        <div class="transaction-step-wrapper">
            <div class="transaction-step">
                <TransactionSteps current-step="completed" />

                <FiftyText variation="heading-3">

                    Transaction Id: {{ transactionId }}
                </FiftyText>
                <FiftyText variation="heading-4">
                    Your post is created
                </FiftyText>

            </div>
        </div>
    </GuestLayout>
</template>

<script>
export default {
    name: 'ReceiverInformation'
}
</script>
