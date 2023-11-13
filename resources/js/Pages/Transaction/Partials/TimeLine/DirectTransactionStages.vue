<script setup>
import {transactionStatuses} from "@/helpers/transactionStatuses";
import {useHelpers} from "@/Composables/useHelpers";
import {useAPI} from "@/Composables/useAPI";
import {useNotificationStore} from "@/stores/notification";
import {currencies_countries} from "@/helpers/currencies_countries";
import Initialized from "@/Pages/Transaction/Partials/TimeLine/Stages/Initialized.vue";
import PairingPending from "@/Pages/Transaction/Partials/TimeLine/Stages/PairingPending.vue";
import PairingComplete from "@/Pages/Transaction/Partials/TimeLine/Stages/PairingComplete.vue";
import PaymentToReceiverCompleted from "@/Pages/Transaction/Partials/TimeLine/Stages/PaymentToReceiverCompleted.vue";
import PaymentToOppositeReceiverPending
    from "@/Pages/Transaction/Partials/TimeLine/Stages/PaymentToOppositeReceiverPending.vue";
import PaymentToOppositeReceiverConfirmed
    from "@/Pages/Transaction/Partials/TimeLine/Stages/PaymentToOppositeReceiverConfirmed.vue";
import TransactionCompleted from "@/Pages/Transaction/Partials/TimeLine/Stages/TransactionCompleted.vue";
import TransactionStage from "@/Pages/Transaction/Partials/TimeLine/Stages/TransactionStage.vue";

const props = defineProps({
    transaction: {
        type: Object,
        required: true
    }
})


const emit = defineEmits(['transactionUpdated'])

const api = useAPI()
const notification = useNotificationStore();
const helpers = useHelpers()

const transactionUpdated = (transaction) => {
    emit('transactionUpdated', transaction)
}


// Used data:
const receiverName = props.transaction.receiver?.first_name;
const receiverCountry = helpers.getCountryLabelByCode(props.transaction.receiver.country) + `(${props.transaction.receiver.country})`;
const amountInReceiverCurrency = helpers.amountHumanReadableWithCurrency(props.transaction.payment_intent.amount_in_receiver_currency) + ` (${currencies_countries[props.transaction.receiver.country]})`

</script>

<template>
    <div class="transaction-stages-wrapper">
        <ol class="relative border-l border-grey-200">
            <!-- 1- Transaction initialized -->
            <initialized :transaction="transaction">
                A hold of {{ helpers.amountHumanReadableWithCurrency(transaction.payment_intent.amount) }}
                <span class="uppercase">
                    ({{ transaction.payment_intent.currency }})
                </span>
                has been placed on your card and will be refunded once the transaction is complete.
            </initialized>

            <!-- 2- Transaction Pairing pending -->
            <PairingPending :transaction="transaction">
                Money order for <b>{{ receiverName }}</b> has been posted in
                <b>{{ receiverCountry }}.</b>

            </PairingPending>

            <!-- 3- Transaction Pairing complete -->
            <PairingComplete
                :is-hidden="transactionStatuses[transaction.status] < 3"
                :transaction="transaction"
            >

                <b>{{ transaction.opposite_transaction?.user?.first_name }}</b> in
                <b>{{ receiverCountry }} </b>
                has accepted your Money Order and now paying
                <b> {{ amountInReceiverCurrency }} </b>
                to
                <b>{{ receiverName }}</b>

            </PairingComplete>

            <!-- 4- PAYMENT_TO_RECEIVER_PENDING -->

            <!-- 5- Transaction Payment to receiver complete -->
            <PaymentToReceiverCompleted
                :is-hidden="transactionStatuses[transaction.status] < 5"
                :transaction="transaction"
                @transactionUpdated="transactionUpdated"
            >

                <b>{{ receiverName }}</b> has been paid <b> {{ amountInReceiverCurrency }} </b>.

                Please confirm with <b>{{ receiverName }}</b> and view receipt.

            </PaymentToReceiverCompleted>

            <!-- 6- Transaction Payment to receiver confirmed -->

            <TransactionStage
                :date="transaction.payment_to_receiver_confirmed_at"
                :is-hidden="transactionStatuses[transaction.status] < 6"
                text=""
                title="Payment Confirmed"
            >
                <b> {{ receiverName }}</b> has received <b>{{ amountInReceiverCurrency }}.</b>
            </TransactionStage>

            <!-- 7- OPPOSITE_PAYMENT_TO_RECEIVER_PENDING (we ask for payment) -->
            <PaymentToOppositeReceiverPending :is-hidden="transactionStatuses[transaction.status] < 6"
                                              :transaction="transaction"/>

            <!-- 8- OPPOSITE_PAYMENT_TO_RECEIVER_COMPLETE -->

            <!-- 9- OPPOSITE_PAYMENT_TO_RECEIVER_CONFIRMED -->
            <PaymentToOppositeReceiverConfirmed :is-hidden="transactionStatuses[transaction.status] < 9"
                                                :transaction="transaction"
            />


            <!-- 10- TRANSACTION_COMPLETED -->
            <TransactionCompleted
                :is-hidden="transactionStatuses[transaction.status] < 10"
                :transaction="transaction"
            />

        </ol>
    </div>
</template>

<script>
export default {
    name: 'DirectTransactionStages'
}
</script>
