<script setup>
import { transactionStatuses } from "@/helpers/transactionStatuses";
import { useHelpers } from "@/Composables/useHelpers";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";
import { currencies_countries } from "@/helpers/currencies_countries";
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
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    transaction: {
        type: Object,
        required: true
    }
})


const emit = defineEmits(['transactionUpdated'])

const api = useAPI()
const notification = useNotificationStore();
const helpers = useHelpers();

const transactionUpdated = (transaction) => {
    emit('transactionUpdated', transaction)
}


// Used data:
const receiverName = props.transaction?.receiver_firstname;
const receiverCountry = props.transaction?.receiver_country + `(${helpers.getCodeLabelByCountry(props.transaction?.receiver_country)})`;
const amountInReceiverCurrency = helpers.amountHumanReadableWithCurrency(props.transaction?.receiver_amount) + ` (${props.transaction?.receiver_currency})`


console.log(props.transaction, "transaction")

const outerDetail = props.transaction;
const detail = outerDetail.transaction_config;
const proof_img = detail.proof_url

console.log(detail, "app response");

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
            <PairingComplete v-if="detail.pairing_complete" :is-hidden="transactionStatuses[transaction?.status] < 3"
                :transaction="detail" />

            <div v-if="outerDetail.payment2">
                <img class="w-1/2 my-10 rounded-xl border border-solid-blue" :src="`${proof_img}`" />
            </div>

            <!-- 4- PAYMENT_TO_RECEIVER_PENDING -->

            <!-- 5- Transaction Payment to receiver complete -->






            <!-- <TransactionStage v-if="detail.payment_confirmed_second" :transaction="detail"
                :is-hidden="transactionStatuses[transaction?.status] < 6" /> -->

            <div v-if="outerDetail.payment2 === true && detail.payment_confirmed === true">
                <TransactionStage v-if="detail.payment_confirmed" :transaction="detail"
                    :is-hidden="transactionStatuses[transaction?.status] < 6" />
            </div>

            <PaymentToReceiverCompleted v-if="detail.payment_complete"
                :is-hidden="transactionStatuses[transaction?.status] < 5" :transaction="outerDetail"
                @transactionUpdated="transactionUpdated" />

            <div v-if="outerDetail.payment2 === false && detail.payment_confirmed === true">
                <TransactionStage v-if="detail.payment_confirmed" :transaction="detail"
                    :is-hidden="transactionStatuses[transaction?.status] < 6" />
            </div>

            <li v-if="detail.payment_confirmed_second" :class="{ 'opacity-30': isHidden }">
                <div class="track-step-icon w-3 h-3 mt-1.5 -left-1.5 border border-white"></div>

                <FiftyText class="mb-2">
                    {{ helpers.getDateFormat(Number(detail.payment_confirmed_second_time)) }}


                </FiftyText>

                <FiftyText class="transaction-heading" variation="body-xl" color="dark">
                    {{ detail.payment_confirmed_second_title }}
                </FiftyText>

                <FiftyText>
                    {{ detail.payment_confirmed_second_message }}
                </FiftyText>
            </li>




            <!-- 6- Transaction Payment to receiver confirmed -->



            <!-- 7- OPPOSITE_PAYMENT_TO_RECEIVER_PENDING (we ask for payment) -->
            <!-- <PaymentToOppositeReceiverPending :is-hidden="transactionStatuses[transaction?.status] < 6"
                                              :transaction="transaction"/> -->

            <!-- 8- OPPOSITE_PAYMENT_TO_RECEIVER_COMPLETE -->

            <!-- 9- OPPOSITE_PAYMENT_TO_RECEIVER_CONFIRMED -->
            <PaymentToOppositeReceiverConfirmed v-if="detail.send_payment"
                :is-hidden="transactionStatuses[transaction?.status] < 9" :transaction="detail" />


            <!-- 10- TRANSACTION_COMPLETED -->
            <TransactionCompleted v-if="detail.thank_you" :is-hidden="transactionStatuses[transaction?.status] < 10"
                :transaction="detail" />


            <div v-if="detail.is_stucked === false && detail.send_payment === true">
                <li>
                    <FiftyText class="transaction-heading" variation="body-xl" color="dark">
                        Receiver information
                    </FiftyText>
                </li>


                <li>
                    <div class="flex gap-2">
                        <FiftyText>
                            First name:
                        </FiftyText>
                        <FiftyText class="font-semibold">
                            {{ outerDetail.receiver_firstname }}
                        </FiftyText>
                    </div>
                    <div class="mt-1.5 flex gap-2">
                        <FiftyText>
                            Last name:
                        </FiftyText>
                        <FiftyText class="font-semibold">
                            {{ outerDetail.receiver_lastname }}

                        </FiftyText>
                    </div>
                    <div class="mt-1.5 flex gap-2">
                        <FiftyText>
                            Email:
                        </FiftyText>
                        <FiftyText class="font-semibold">
                            {{ outerDetail.receiver_email }}
                        </FiftyText>
                    </div>
                    <div class="mt-1.5 flex gap-2">
                        <FiftyText>
                            Phone:
                        </FiftyText>
                        <FiftyText class="font-semibold">
                            {{ outerDetail.receiver_phone }}
                        </FiftyText>
                    </div>

                    <div class="mt-1.5 flex gap-2">
                        <FiftyText>
                            Country:
                        </FiftyText>
                        <FiftyText class="font-semibold">
                            {{ outerDetail.receiver_country }}
                        </FiftyText>
                    </div>

                    <div class="mt-1.5 flex gap-2">
                        <FiftyText>
                            Bank:
                        </FiftyText>
                        <FiftyText class="font-semibold">
                            {{ outerDetail.receiver_bank_name }}
                        </FiftyText>
                    </div>
                    <div class="mt-1.5 flex gap-2">
                        <FiftyText>
                            Branch Name:
                        </FiftyText>
                        <FiftyText class="font-semibold">
                            {{ outerDetail.receiver_branch_name }}
                        </FiftyText>
                    </div>
                    <div class="mt-1.5 flex gap-2">
                        <FiftyText>
                            Account Number:
                        </FiftyText>
                        <FiftyText class="font-semibold">
                            {{ outerDetail.receiver_bank_account_number }}
                        </FiftyText>
                    </div>
                    <div class="mt-1.5 flex gap-2">
                        <FiftyText>
                            Comments:
                        </FiftyText>
                        <FiftyText class="font-semibold">
                            Please
                        </FiftyText>
                    </div>
                    <div v-if="outerDetail.payment2 === false">
                        <img class="w-1/2 mt-10 rounded-xl border border-solid-blue" :src="`${proof_img}`" />
                    </div>
                </li>
            </div>
        </ol>



    </div>
</template>

<script>
export default {
    name: 'AppResponse'
}
</script>
