<script setup>
import {Head, router} from '@inertiajs/vue3';
import {onMounted, reactive, ref} from "vue";
import GuestLayout from '@/Layouts/GuestLayout.vue';
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import NewTextInput from "@/Components/Design/NewTextInput.vue";
import DirectTransactionStages from "@/Pages/Transaction/Partials/TimeLine/DirectTransactionStages.vue";
import OppositeTransactionStages from "@/Pages/Transaction/Partials/TimeLine/OppositeTransactionStages.vue";
import {useNotificationStore} from "@/stores/notification";
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    transaction: {
        default: null,
        type: Object
    }
})

console.log(props.transaction);

const notification = useNotificationStore()

// Find transaction:
const transactionId = ref('');

const findTransaction = () => {
    router.get('/track-transaction?transaction=' + transactionId.value)
}

// current transaction

const currentTransaction = reactive({});

const updateTransaction = (transaction) => {
    currentTransaction.value = transaction;
}

onMounted(() => {
    currentTransaction.value = props.transaction;

    Echo.channel('transaction-channel-' + props.transaction?.id)
        .listen('TransactionUpdated', (e) => {
            notification.notify('Transaction has been updated.', 'success')
            router.get('/track-transaction?transaction=' + e.transactionId)
        });
})


</script>

<template>
    <GuestLayout>
        <Head title="Fifty-Fifty | Send Money">
            <title>
                Fifty-Fifty | Transaction
            </title>
        </Head>

        <div class="timeline-wrapper">
            <div class="timeline relative">
                <div class="track-steps-wrapper" v-if="currentTransaction.value">
                    <FiftyText variation="heading-3">
                        {{ transaction.user?.first_name }}, your money is on its way
                    </FiftyText>

                    <div class="transaction-info">
                        <FiftyText>
                            Transaction #:
                        </FiftyText>
                        <span>{{ transaction.id }}</span>
                    </div>

                    <DirectTransactionStages
                        v-if="transaction.type === 'direct'"
                        :transaction="currentTransaction.value"
                        @transactionUpdated="updateTransaction"
                    />

                    <OppositeTransactionStages
                        v-else :transaction="currentTransaction.value"
                        @transactionUpdated="updateTransaction"
                    />
                </div>

                <div v-else class="track-form-wrapper">
                    <NewTextInput
                        v-model="transactionId"
                        label="Transaction Number"
                        placeholder="Transaction Number (12 chars)"
                        required
                        title="transactionId"
                    />

                    <NewActionButton
                        @click="findTransaction"
                        title="Track"
                        class="track-form-action-button"
                    />

                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script>
export default {
    name: 'Timeline'
}
</script>
