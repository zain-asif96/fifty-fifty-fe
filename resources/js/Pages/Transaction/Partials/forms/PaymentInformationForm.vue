<!-- <script setup>
import { computed, onMounted, reactive, ref, watch } from "vue";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";
import { router, usePage } from "@inertiajs/vue3";
import { currencies } from "@/helpers/currencies";
import { currencies_countries } from "@/helpers/currencies_countries";
import cardInfo from "@/Pages/Transaction/Partials/forms/CardInfo.vue";

import Spinner from "@/Components/Custom/Spinner.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import NewTextInput from "@/Components/Design/NewTextInput.vue";
import NewSelectInput from "@/Components/Design/NewSelectInput.vue";
import FiftyText from "@/Components/Design/FiftyText.vue";

const emit = defineEmits(['stepChanged'])
const api = useAPI();
const notification = useNotificationStore();
const geoLocationDetails = usePage().props.geoDetails;
const isLoadingCurrencyRate = ref(false);
const currentRate = ref(0);
const isTransactionPreset = ref(false);

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
let showCardInfoDialog = ref(false)
const validationError = ref('');
const transactionInfo = reactive({
    'amount': '100',
    'currency': currencies_countries[geoLocationDetails.country_code],
    'country': '',
});
const openCardInfo = () => {
    if (!transactionInfo.amount || !transactionInfo.currency || !transactionInfo.country) {
        validationError.value = 'Please fill in all the required fields.';
        return;
    }

    showCardInfoDialog.value = true;
    cardInfo;
    validationError.value = ""
    return { transactionInfo, validationError, showCardInfoDialog };

}
function closeCardInfoDialog($isFetchData) {
    console.log('$isFetchData', $isFetchData);
    showCardInfoDialog.value = false;
    return { showCardInfoDialog };
}

const convertCurrencyByCountryCode = async () => {
    isLoadingCurrencyRate.value = true;

    const selectedCountry = props.receivingCountries.find((country) => {
        return country.code_iso_2 === transactionInfo.country || country.code === transactionInfo.country
    });

    try {
        const res = await axios.post('/api/convert-currency', {
            'baseCurrency': transactionInfo.currency,
            'requiredCurrency': selectedCountry.currency.code
        });

        currentRate.value = res?.data[selectedCountry.currency.code].value

    } catch (errors) {
        notification.notify('Exchange rate is not available at the moment..', 'error');
    } finally {
        isLoadingCurrencyRate.value = false;
    }
}



const setTransactionValues = () => {
    transactionInfo.amount = parseFloat((props.user.handled_transaction.payment_intent.amount_in_receiver_currency / 100).toFixed(2));
    transactionInfo.country = props.user.handled_transaction.user.country
}

onMounted(() => {
    isTransactionPreset.value = !!props.user.transaction_id;
    if (isTransactionPreset.value) {
        setTransactionValues();
    }

})

// Cancelling:
const cancel = () => {
    router.visit('/');
}

// receiver will get amount:

const receiverGetsAmount = computed(() => {
    return parseFloat((currentRate.value * transactionInfo.amount).toFixed(2))
});

</script>

<template>
    <cardInfo :show="showCardInfoDialog" :user="props.user" :transactionInfo="transactionInfo" v-if="showCardInfoDialog"
        v-on:close="closeCardInfoDialog($event)" />
    <div class="transaction-info-form-wrapper">

        <NewTextInput v-model="transactionInfo.amount" :disabled="isTransactionPreset" :errors="api.errors.value?.amount"
            label="Amount" placeholder="99" required title="amount" class="fifty-form-input" type="number" />

        <NewSelectInput v-model="transactionInfo.currency" :disabled="isTransactionPreset"
            :errors="api.errors.value?.currency" :options="currencies" label="Currency"
            placeholder="Currency of your payment card" required title="country" class="fifty-form-input" type="text"
            @update:modelValue="convertCurrencyByCountryCode" />

        <NewSelectInput v-model="transactionInfo.country" :disabled="isTransactionPreset"
            :errors="api.errors.value?.country" :options="receivingCountries" label="Receiver Country"
            label-accessor="label" placeholder="Country" required title="country" class="fifty-form-input country"
            type="text" value-accessor="code_iso_2" @update:modelValue="convertCurrencyByCountryCode" />

        <transition mode="out-in" name="fade">
            <div v-if="currentRate && transactionInfo.amount" class="receiver-gets-wrapper m-auto">
                <div class="receiver-gets">
                    <FiftyText class="title">
                        The receiver will get approximately
                    </FiftyText>
                    <Spinner v-if="isLoadingCurrencyRate" />
                    <div class="amount" v-else>
                        {{ receiverGetsAmount }} {{ currencies_countries[transactionInfo.country] }}
                    </div>
                </div>
            </div>
        </transition>
        <p class="text-danger">{{ validationError }}</p>
        <div class="action-buttons">
            <NewActionButton :reversed="true" type="button" title="Cancel" @click="cancel" />

            <NewActionButton :isLoading="api.isLoading.value" type="button" title="Continue" @click="openCardInfo" />
        </div>
    </div>
</template>

<script>
export default {
    name: 'PaymentInformationForm'
}
</script> -->
<script setup>
import {computed, onMounted, reactive, ref} from "vue";
import {useAPI} from "@/Composables/useAPI";
import {useNotificationStore} from "@/stores/notification";
import {router, usePage} from "@inertiajs/vue3";
import {currencies} from "@/helpers/currencies";
import {currencies_countries} from "@/helpers/currencies_countries";
import Spinner from "@/Components/Custom/Spinner.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import NewTextInput from "@/Components/Design/NewTextInput.vue";
import NewSelectInput from "@/Components/Design/NewSelectInput.vue";
import FiftyText from "@/Components/Design/FiftyText.vue";

const emit = defineEmits(['stepChanged'])
const api = useAPI();
const notification = useNotificationStore();
const geoLocationDetails = usePage().props.geoDetails;
const isLoadingCurrencyRate = ref(false);
const currentRate = ref(0);
const isTransactionPreset = ref(false);

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


const transactionInfo = reactive({
    'amount': '',
    'currency': currencies_countries[geoLocationDetails.country_code],
    'country': '',
});

const saveTransactionInfo = async () => {
    api.startRequest();

    try {
        const res = await axios.post('/api/collect-payment-info', transactionInfo);
        if (res.data.status === 'success') {
            goForward('/receiver-info?payment-reference-identification=' + res.data.paymentIntent.id + '&country=' + transactionInfo.country);
        } else {
            notification.notify('Unexpected error happen', 'error');
        }
    } catch (errors) {
        api.handleErrors(errors)
        notification.notify('Invalid data submitted', 'error');
    } finally {
        api.requestCompleted();
    }
}

const convertCurrencyByCountryCode = async () => {
    isLoadingCurrencyRate.value = true;

    const selectedCountry = props.receivingCountries.find((country) => {
        return country.code_iso_2 === transactionInfo.country || country.code === transactionInfo.country
    });

    try {
        const res = await axios.post('/api/convert-currency', {
            'baseCurrency': transactionInfo.currency,
            'requiredCurrency': selectedCountry.currency.code
        });

        currentRate.value = res?.data[selectedCountry.currency.code].value

    } catch (errors) {
        notification.notify('Exchange rate is not available at the moment..', 'error');
    } finally {
        isLoadingCurrencyRate.value = false;
    }
}

const goForward = (url) => {
    router.get(url);
}

const setTransactionValues = () => {
    transactionInfo.amount = parseFloat((props.user.handled_transaction.payment_intent.amount_in_receiver_currency / 100).toFixed(2));
    transactionInfo.country = props.user.handled_transaction.user.country
}

onMounted(() => {
    isTransactionPreset.value = !!props.user.transaction_id;

    if (isTransactionPreset.value) {
        setTransactionValues();
    }

})

// Cancelling:
const cancel = () => {
    router.visit('/');
}

// receiver will get amount:

const receiverGetsAmount = computed( () => {
    return parseFloat((currentRate.value * transactionInfo.amount).toFixed(2))
});

</script>

<template>
    <div class="transaction-info-form-wrapper">
        <NewTextInput
            v-model="transactionInfo.amount"
            :disabled="isTransactionPreset"
            :errors="api.errors.value?.amount"
            label="Amount"
            placeholder="99"
            required
            title="amount"
            class="fifty-form-input"
            type="number"
        />

        <NewSelectInput
            v-model="transactionInfo.currency"
            :disabled="isTransactionPreset"
            :errors="api.errors.value?.currency"
            :options="currencies"
            label="Currency"
            placeholder="Currency of your payment card"
            required
            title="country"
            class="fifty-form-input"
            type="text"
            @update:modelValue="convertCurrencyByCountryCode"
        />

        <NewSelectInput
            v-model="transactionInfo.country"
            :disabled="isTransactionPreset"
            :errors="api.errors.value?.country"
            :options="receivingCountries"
            label="Receiver Country"
            label-accessor="label"
            placeholder="Country"
            required
            title="country"
            class="fifty-form-input country"
            type="text"
            value-accessor="code_iso_2"
            @update:modelValue="convertCurrencyByCountryCode"
        />

        <transition mode="out-in" name="fade">
            <div v-if="currentRate && transactionInfo.amount" class="receiver-gets-wrapper m-auto">
                <div class="receiver-gets">
                    <FiftyText class="title">
                        The receiver will get approximately
                    </FiftyText>
                    <Spinner v-if="isLoadingCurrencyRate"/>
                    <div class="amount" v-else>
                        {{ receiverGetsAmount }} {{ currencies_countries[transactionInfo.country] }}
                    </div>
                </div>
            </div>
        </transition>

        <div class="action-buttons">
            <NewActionButton
                :reversed="true"
                type="button"
                title="Cancel"
                @click="cancel"
            />

            <NewActionButton
                :isLoading="api.isLoading.value"
                type="button"
                title="Continue"
                @click="saveTransactionInfo"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: 'PaymentInformationForm'
}
</script>
