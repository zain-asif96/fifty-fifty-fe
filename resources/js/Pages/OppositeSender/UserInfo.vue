<script setup>
import {Head} from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import SenderInfoForm from "@/Pages/Transaction/Partials/forms/SenderInfoForm.vue";
import {onMounted} from "vue";
import FiftyText from "@/Components/Design/FiftyText.vue";
import TransactionSteps from "@/Pages/Transaction/Partials/TransactionSteps.vue";

const props = defineProps({
    transactionId: {
        required: true,
        type: String
    }
})


onMounted(() => {
    window.sessionStorage.setItem('resend-timer', 60);
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
                    <SenderInfoForm :transactionId="props.transactionId"/>
                </Transition>
            </div>
        </div>
    </GuestLayout>
</template>

<script>
export default {
    name: 'OppositeSender:UserInfo'
}
</script>
