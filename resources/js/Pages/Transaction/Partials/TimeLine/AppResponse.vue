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
import { timestamp } from "@vueuse/core";

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
const receiverName = props.transaction?.receiver_firstname;
const receiverCountry = props.transaction?.receiver_country + `(${helpers.getCodeLabelByCountry(props.transaction?.receiver_country)})`;
const amountInReceiverCurrency = helpers.amountHumanReadableWithCurrency(props.transaction?.receiver_amount) + ` (${props.transaction?.receiver_currency})`


console.log(props.transaction.transaction_config,"app response")

const detail = props.transaction.transaction_config

</script>


<!-- app = E718885426  -->


<!-- web E24981F1A3FD -->

<template>
     <div class="transaction-stages-wrapper">
        <ol class="relative border-l border-grey-200">
            <!-- 1- Transaction initialized -->
            <initialized v-if="detail.initialize" :transaction="detail" />
           

            <!-- 2- Transaction Pairing pending -->
            <PairingPending v-if="detail.pairing_pending" :transaction="detail" />
            

            <!-- 3- Transaction Pairing complete -->
            <PairingComplete 
                v-if="detail.pairing_complete"
                :is-hidden="transactionStatuses[transaction?.status] < 3"
                :transaction="detail"
            />

               

            

            <!-- 4- PAYMENT_TO_RECEIVER_PENDING -->

            <!-- 5- Transaction Payment to receiver complete -->
            <PaymentToReceiverCompleted
                v-if="detail.payment_complete"
                :is-hidden="transactionStatuses[transaction?.status] < 5"
                :transaction="detail"
                @transactionUpdated="transactionUpdated"
            />

                

           

            <!-- 6- Transaction Payment to receiver confirmed -->

            <TransactionStage
                 v-if="detail.payment_confirmed"
                :transaction="detail"
                :is-hidden="transactionStatuses[transaction?.status] < 6"
            />

            <!-- 7- OPPOSITE_PAYMENT_TO_RECEIVER_PENDING (we ask for payment) -->
            <!-- <PaymentToOppositeReceiverPending :is-hidden="transactionStatuses[transaction?.status] < 6"
                                              :transaction="transaction"/> -->

            <!-- 8- OPPOSITE_PAYMENT_TO_RECEIVER_COMPLETE -->

            <!-- 9- OPPOSITE_PAYMENT_TO_RECEIVER_CONFIRMED -->
            <PaymentToOppositeReceiverConfirmed
            v-if="detail.send_payment"
            :is-hidden="transactionStatuses[transaction?.status] < 9"
            :transaction="detail"
            />


            <!-- 10- TRANSACTION_COMPLETED -->
            <TransactionCompleted
                v-if="detail.thank_you"
                :is-hidden="transactionStatuses[transaction?.status] < 10"
                :transaction="detail"
            />

        </ol>
    </div>
</template>

<script>
export default {
    name: 'AppResponse'
}
</script>
