<script setup>
import { computed, onMounted, reactive, ref, } from "vue";
import InternationalTelInput from "@/Components/Custom/InternationalTelInput.vue";
import { VueTelInput } from 'vue-tel-input';
import { router, usePage } from "@inertiajs/vue3";
import 'vue-tel-input/dist/vue-tel-input.css';
import { useAPI } from "@/Composables/useAPI";
import { countries } from "@/helpers/countries";
import { currencies_countries } from "@/helpers/currencies_countries";
import { currencies } from "@/helpers/currencies";
import { useNotificationStore } from "@/stores/notification";
import NewTextInput from "@/Components/Design/NewTextInput.vue";
import RadioButton from "@/Components/Custom/RadioButton.vue";
import NewSelectInput from "@/Components/Design/NewSelectInput.vue";
import FiftyText from "@/Components/Design/FiftyText.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import NewTextArea from "@/Components/Design/NewTextArea.vue";

import Spinner from "@/Components/Custom/Spinner.vue";
const props = defineProps({
    transactionId: {
        required: false,
        type: String,
    },
    user: {
        // required: true,
        default: null,
        type: Object
    },
    commissions: {
        default: null,
        type: Object
    },
    receivingCountries: {
        required: true,
        default: [],
        type: Array
    }
})
console.log('commissions', props.commissions);
const emit = defineEmits(['stepChanged'])
const api = useAPI();
const notification = useNotificationStore();
const geoLocationDetails = usePage().props.geoDetails;
const isLoadingCurrencyRate = ref(false);
const currentRate = ref(0);
const isTransactionPreset = ref(false);
const totalAmount = ref(false)
const bankOptions = ref([]);
const user = reactive({
    'first_name': '',
    'country': geoLocationDetails.country_code,
    'last_name': '',
    'email': '',
    'phone': '',
    'amount': '',
    'amountTotal': '',
    'currency': currencies_countries[geoLocationDetails.country_code],
    'receiver_first_name': '',
    'receiver_last_name': '',
    'receiver_email': '',
    'receiver_phone': '',
    'receiver_country': '',
    'receiver_bank_id': '',
    'receiver_account_number': '',
    'receiver_branch_number': '',
    'receiver_banking_info': '',
    'flag': 'send_now',
    'type': 'bank',
})
const convertCurrencyByCountryCode = async () => {
    isLoadingCurrencyRate.value = true;

    const selectedCountry = props.receivingCountries.find((country) => {
        return country.code_iso_2 === user.receiver_country || country.code === user.receiver_country
    });

    try {
        const res = await axios.post('/api/convert-currency', {
            'baseCurrency': user.currency,
            'requiredCurrency': selectedCountry.currency.code
        });

        currentRate.value = res?.data[selectedCountry.currency.code].value

    } catch (errors) {
        notification.notify('Exchange rate is not available at the moment..', 'error');
    } finally {
        isLoadingCurrencyRate.value = false;
    }
}
const verifyUserInformation = async (e) => {
    e.preventDefault();
    api.startRequest();
    console.log('user', user);
    user.amountTotal = totalValue.value.toString()
    try {
        const res = await axios.post('/api/validate-info', { ...user, transactionId: props.transactionId });
        if (res.data.status === 'success') router.get('/verify-contacts?source=' + (props.transactionId ?? 'direct'));
    } catch (errors) {
        notification.notify('Something went wrong...', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
};
const receiverGetsAmount = computed(() => {
    return parseFloat((currentRate.value * user.amount).toFixed(2))
});
const phoneCountryChanged = (countryObject) => {
    user.phone = '+' + countryObject.dialCode;
}
const receiverPhoneCountryChanged = (countryObject) => {
    user.receiver_phone = '+' + countryObject.dialCode;
}

// Cancelling:
const cancel = () => {
    router.visit('/');
}
let totalValue = ref(0)
function setTotal() {
    totalAmount.value = true
    let total = parseFloat(user.amount)
    for (const range of props.commissions) {
        console.log('props.commissions', props.commissions);

        if (total > parseFloat(range.from) && total <= parseFloat(range.to)) {
            console.log('range.amount)', range.amount);

            total = total + parseFloat(range.amount)        // return;
        }
    }
    console.log('total', total);
    totalValue.value = total
    return { totalValue }
}
const getBankList = async () => {
    api.startRequest();
    let country = user.receiver_country
    console.log('country', country);
    try {
        const res = await axios.get('/api/get-international-banks?country_code=' + country);
        console.log('res.banks', res);
        if (res.data.status == 'success') {
            bankOptions.value = []
            console.log('res.banks', res.banks);
            res.data.banks.forEach(bank => {
                bankOptions.value.push({
                    'label': bank.label,
                    'value': bank.id,
                })
            });
            console.log('bankoptions', bankOptions.value);
            convertCurrencyByCountryCode()
            // console.log('banks.value',bankOptions.value);
            // return {bankOptions}
        }
    } catch (errors) {
        notification.notify('Something went wrong...', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
};
// const setTransactionValues = () => {
//     user.amount = parseFloat((props.user.handled_transaction.payment_intent.amount_in_receiver_currency / 100).toFixed(2));
//     user.country = props.user.handled_transaction.user.country
// }

// onMounted(() => {
//     isTransactionPreset.value = !!props.user.transaction_id;
//     if (isTransactionPreset.value) {
//         setTransactionValues();
//     }

// })
onMounted(() => {

    let amount = route().params.amount;
    let receiver_country = route().params.receiver_country;
    let receiver_gets = route().params.receiver_gets;
    user.amount = amount ? amount : ''
    user.receiver_country = receiver_country ? receiver_country : ''

    if (user.amount != '') {
        setTotal()
    }
    if (receiver_gets != "") {
        currentRate.value = receiver_gets
        receiverGetsAmount.value = receiver_gets
    }
    if (user.receiver_country) {
        getBankList()
    }
});
const updateOptions = () => {
    // console.log('before type', user.type);

    // if (user.type == 'bank') {
    //     user.type = 'transfer';
    // } else {
    //     user.type = 'bank';
    // }
    // console.log('after type', user.type);
}
const radioOptions = [
  { label: 'Bank', value: 'bank' },
  { label: 'E-Money/Transfer', value: 'transfer' },
];
</script>

<template>
    <div class="sender-info-form-wrapper">

        <NewTextInput v-model="user.first_name" :errors="api.errors.value?.first_name" label="First Name" placeholder="John"
            required title="first_name" class="sender-input" />

        <NewTextInput v-model="user.last_name" :errors="api.errors.value?.last_name" label="Last Name" placeholder="Doe"
            required title="last_name" class="sender-input" />

        <NewTextInput v-model="user.email" :errors="api.errors.value?.email" label="Email" placeholder="john@example.com"
            required title="email" class="sender-input" />

        <InternationalTelInput :errors="api.errors.value?.phone" :required="true" label="Phone Number" title="phone"
            class="sender-input">
            <vue-tel-input id="exampleFormControlInput1" ref="input" v-model="user.phone"
                :class="{ 'error-border': api.errors.value?.phone?.length > 0 }"
                :defaultCountry="geoLocationDetails?.country_code" :inputOptions="{ 'placeholder': '123456789' }" class="form-control block w-full px-0 py-0 text-lg font-normal h-10
                  text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition
                  ease-linear m-0
                  focus:text-gray-700 focus:bg-white focus:border-indigo-300 focus:outline-none" mode="international"
                @country-changed="phoneCountryChanged">

            </vue-tel-input>
        </InternationalTelInput>
        <NewTextInput v-model="user.amount" :disabled="isTransactionPreset" :errors="api.errors.value?.amount"
            label="Amount" placeholder="99" required title="amount" class="fifty-form-input" type="number"
            @update:modelValue="setTotal" />
        <NewSelectInput v-model="user.country" :errors="api.errors.value?.country" :options="countries" disabled
            label="Country" placeholder="Country" required title="country" type="text" class="fifty-form-input" />


        <FiftyText variation="heading-3">
            Enter Receiver Information
        </FiftyText>


        <!-- <NewSelectInput v-model="user.currency" :disabled="isTransactionPreset" :errors="api.errors.value?.currency"
            :options="currencies" label="Currency" placeholder="Currency of your payment card" required title="country"
            class="fifty-form-input" type="text" @update:modelValue="convertCurrencyByCountryCode" />

        <NewSelectInput v-model="user.receiver_country" :disabled="isTransactionPreset"
            :errors="api.errors.value?.receiver_country" :options="receivingCountries" label="Receiver Country"
            label-accessor="label" placeholder="Country" required title="country" class="fifty-form-input country"
            type="text" value-accessor="code_iso_2" @update:modelValue="convertCurrencyByCountryCode" /> -->

        <!-- start -->
        <div class="receiver-info-form-wrapper">
            <NewTextInput class="fifty-form-input" v-model="user.receiver_first_name"
                :errors="api.errors.value?.receiver_first_name" label="First Name" placeholder="John" required
                title="first_name" />
            <NewTextInput class="fifty-form-input" v-model="user.receiver_last_name"
                :errors="api.errors.value?.receiver_last_name" label="Last Name" placeholder="Doe" required
                title="last_name" />
            <NewTextInput class="fifty-form-input" v-model="user.receiver_email" :errors="api.errors.value?.receiver_email"
                label="Email" placeholder="john@example.com" title="email" />


            <InternationalTelInput :errors="api.errors.value?.receiver_phone" :required="false" label="Phone Number"
                title="phone" class="fifty-form-input">
                <vue-tel-input id="exampleFormControlInput1" ref="input" v-model="user.receiver_phone"
                    :class="{ 'error-border': api.errors.value?.receiver_phone?.length > 0 }"
                    :inputOptions="{ 'placeholder': '123456789' }"
                    :onlyCountries="isTransactionPreset ? [user.receiver_country] : []" class="form-control block w-full px-0 py-0 text-lg font-normal h-10
              text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition
              ease-linear m-0
              focus:text-gray-700 focus:bg-white focus:border-indigo-300 focus:outline-none" mode="international"
                    @country-changed="receiverPhoneCountryChanged">

                </vue-tel-input>
            </InternationalTelInput>
            <RadioButton v-model="user.type" :customStyle="{width: 'inherit'}" :title="'Type'" :label="'Type'" :options="radioOptions" @update:modelValue="updateOptions" />

            <NewSelectInput class="fifty-form-input" v-model="user.receiver_country"
                :errors="api.errors.value?.receiver_country" :options="countries" label="Country" placeholder="Country"
                required title="country" type="text" @update:modelValue="getBankList" />

            <NewSelectInput v-if="user.type == 'bank'" class="fifty-form-input" v-model="user.receiver_bank_id"
                :errors="api.errors.value?.receiver_bank_id" :options="bankOptions" label="International Bank"
                placeholder="International Bank" required title="bank" type="text" />
            <NewTextInput v-if="user.type == 'bank'" class="fifty-form-input" v-model="user.receiver_account_number"
                :errors="api.errors.value?.receiver_account_number" label="Account Number" placeholder="123456789" required
                title="account_number" />
            <NewTextInput v-if="user.type == 'bank'" class="fifty-form-input" v-model="user.receiver_branch_number"
                :errors="api.errors.value?.receiver_branch_number" label="Branch Number" placeholder="123456789"
                title="branch_number" />

            <NewTextArea v-model="user.receiver_banking_info" :errors="api.errors.value?.receiver_banking_info"
                label="Additional Information / Comments" placeholder="I am open to different payment options..."
                title="banking_info" />

            <!-- <div class="action-buttons">
                <NewActionButton :reversed="true" title="Back" @click="goBack" />

                <NewActionButton :isLoading="api.isLoading.value" title="Continue" @click="saveReceiver" />
            </div> -->
        </div>

        <!-- end -->
        <transition mode="out-in" name="fade">
            <div v-if="currentRate && user.amount" class="receiver-gets-wrapper m-auto">
                <div class="receiver-gets">
                    <FiftyText class="title">
                        The receiver will get approximately
                    </FiftyText>
                    <Spinner v-if="isLoadingCurrencyRate" />
                    <div class="amount" v-else>
                        {{ receiverGetsAmount }} {{ currencies_countries[user.receiver_country] }}
                    </div>
                </div>
            </div>

        </transition>
        <transition mode="out-in" name="fade">
            <div v-if="totalAmount" class="receiver-gets-wrapper m-auto">
                <div class="receiver-gets">
                    <FiftyText class="title">
                        Total Amount
                    </FiftyText>
                    <!-- <Spinner v-if="isLoadingtotalAmountRate" /> -->
                    <div class="amount">
                        {{ totalValue + ' ' + user.currency }}
                    </div>
                </div>
            </div>
        </transition>

        <!-- <div class="action-buttons"> -->
        <!-- <NewActionButton :reversed="true" type="button" title="Cancel" @click="cancel" /> -->

        <!-- <NewActionButton :isLoading="api.isLoading.value" type="button" title="Continue" @click="openCardInfo" /> -->
        <!-- </div> -->
        <div class="action-buttons">
            <NewActionButton :reversed="true" type="button" title="Cancel" @click="cancel" />

            <NewActionButton :isLoading="api.isLoading.value" title="Continue" @click="verifyUserInformation" />
        </div>
    </div>
</template>

<script>
export default {
    name: "SenderInfo"
}
</script>

