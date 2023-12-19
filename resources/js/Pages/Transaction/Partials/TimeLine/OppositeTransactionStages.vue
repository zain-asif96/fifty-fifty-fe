<script setup>
import {oppositeTransactionStatuses} from "@/helpers/transactionStatuses";
import TransactionStage from "@/Pages/Transaction/Partials/TimeLine/Stages/TransactionStage.vue";
import PaymentToReceiverCompleted from "@/Pages/Transaction/Partials/TimeLine/Stages/PaymentToReceiverCompleted.vue";
import {currencies_countries} from "@/helpers/currencies_countries";
import {useHelpers} from "@/Composables/useHelpers";

const props = defineProps({
    transaction: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['transactionUpdated'])

const transactionUpdated = (transaction) => {
    emit('transactionUpdated', transaction)
}
const helpers = useHelpers();

// Used data:
const receiverName = props.transaction.receiver?.first_name;
const receiverCountry = helpers.getCountryLabelByCode(props.transaction.receiver.country) + `(${props.transaction.receiver.country})`;
const amountInReceiverCurrency = helpers.amountHumanReadableWithCurrency(props.transaction.payment_intent.amount_in_receiver_currency) + ` (${currencies_countries[props.transaction.receiver.country]})`

console.log(props.transaction,"web response")


</script>

<template>
    <div class="transaction-stages-wrapper">
        <ol class="relative border-l border-grey-200">
            <!-- Initialized -->
            <TransactionStage
                :date="transaction.created_at"
                text="Your Transaction has been successfully initialized"
                title="Transaction successfully initialized"
            />

            <!-- Pairing complete -->
            <TransactionStage
                :date="transaction.created_at"
                text=""
                title="Pairing is complete"
            >

                <b>{{ transaction.opposite_transaction.user.first_name }}</b> has received your request to complete the
                transaction
                and now viewing the payment proof you
                uploaded.

            </TransactionStage>

            <!-- Payment proof confirmed -->
            <TransactionStage
                :date="transaction.payment_to_opposite_receiver_confirmed_at"
                :is-hidden="oppositeTransactionStatuses[transaction.status] < 3"
                text=""
                title="Payment Confirmed"
            >
                <b>{{ transaction.opposite_transaction.user.first_name }}</b>
                has confirmed your payment, and is now paying the amount
                of:
                <b>{{ amountInReceiverCurrency }}</b>
                to <b> {{ receiverName }} </b>
            </TransactionStage>

            <!-- Payment to receiver completed  -->
            <PaymentToReceiverCompleted
                :is-hidden="oppositeTransactionStatuses[transaction.status] < 4"
                :transaction="transaction"
                @transactionUpdated="transactionUpdated"
            >

                <b>{{ receiverName }}</b> has been paid <b> {{ amountInReceiverCurrency }} </b>.

                Please confirm with <b>{{ receiverName }}</b> and view receipt.


            </PaymentToReceiverCompleted>

            <!-- 10- TRANSACTION_COMPLETED -->

            <TransactionStage
                :date="transaction.transaction_completed_at"
                :is-hidden="oppositeTransactionStatuses[transaction.status] < 5"
                text="Your Transaction has been successfully completed"
                title="Transaction completed!"
            />

            <TransactionStage
                :is-hidden="oppositeTransactionStatuses[transaction.status] < 5"
                date=""
                text=""
                title="Thank you for using 50-50!"
            />

        </ol>
    </div>

</template>

<script>
export default {
    name: 'OppositeTransactionStages'
}
</script>
