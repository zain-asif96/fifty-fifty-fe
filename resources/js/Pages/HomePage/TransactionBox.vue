<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";
import { reactive, ref } from "vue";
import { useAPI } from "@/Composables/useAPI";
import NewTextInput from "@/Components/Design/NewTextInput.vue";
import NewSelectInput from "@/Components/Design/NewSelectInput.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import { usePage } from "@inertiajs/vue3";
import { useNotificationStore } from "@/stores/notification";
import { currencies_countries } from "@/helpers/currencies_countries";
import { router } from '@inertiajs/vue3'

const api = useAPI();
const notification = useNotificationStore();
const errors = reactive({});

const props = defineProps({
    receivingCountries: {
        required: true,
        default: [],
        type: Array
    }
})

const transactionDetails = reactive({
    amount: null,
    country: null,
    convertedAmount: null
})

// Converting amount:
const geoLocationDetails = usePage().props.geoDetails;

const isLoadingCurrencyRate = ref(false);
const currentRate = ref(0);

const convertCurrencyByCountryCode = async () => {
    isLoadingCurrencyRate.value = true;

    const selectedCountry = props.receivingCountries.find((country) => {
        return country.code_iso_2 === transactionDetails.country || country.code === transactionDetails.country
    });

    try {
        const res = await axios.post('/api/convert-currency', {
            'baseCurrency': geoLocationDetails.country.currency.code,
            'requiredCurrency': selectedCountry.currency.code
        });

        console.log({ res });

        currentRate.value = res?.data[selectedCountry.currency.code].value;

        transactionDetails.convertedAmount = getConvertedAmount();

    } catch (errors) {
        notification.notify('Exchange rate is not available at the moment..', 'error');
    } finally {
        isLoadingCurrencyRate.value = false;
    }
}

const amountChanged = () => {
    errors.amount = [];

    if (transactionDetails.amount >= 1000) {
        transactionDetails.amount = 1000;
        return errors.amount = ['1000 is the maximum amount']
    }

    transactionDetails.convertedAmount = getConvertedAmount();
}

const convertAmountChanged = () => {
    errors.convertedAmount = [];

    if (transactionDetails.convertedAmount >= 1000) {
        transactionDetails.convertedAmount = 1000;
        return errors.convertedAmount = ['1000 is the maximum amount']
    }

    transactionDetails.amount = getAmount();
}

const getConvertedAmount = () => {
    return parseFloat((currentRate.value * transactionDetails.amount).toFixed(2));
}

const getAmount = () => {
    return parseFloat((transactionDetails.convertedAmount / currentRate.value).toFixed(2));
}
function getStarted() {
    // route('user.info.page',[transactionDetails.country,,transactionDetails.convertedAmount])
    return router.visit(`/user-info?receiver_country=${transactionDetails.country}&receiver_gets=${transactionDetails.convertedAmount}&amount=${transactionDetails.amount}`);
}
</script>


<template>
    <div class="transaction-box-container">
        <FiftyText color="dark" variation="body-bold" class="font-inter text-custom-dark-blue">
            Provide Your Transaction Details
        </FiftyText>

        <div class="inputs">

            <NewTextInput v-model="transactionDetails.amount" :errors="errors.amount"
                :info="geoLocationDetails.country.currency.code" label="Your amount" placeholder="Amount to send"
                :max="1000" :min="10" required type="number" title="amount" @update:modelValue="amountChanged" />

            <NewSelectInput v-model="transactionDetails.country" :disabled="false" :errors="api.errors.value?.country"
                :options="receivingCountries" label="Receiver Country" label-accessor="label" placeholder="Country" required
                title="country" type="text" value-accessor="code_iso_2" @update:modelValue="convertCurrencyByCountryCode" />

            <NewTextInput :errors="errors.convertedAmount" v-model="transactionDetails.convertedAmount"
                :info="currencies_countries[transactionDetails.country] ?? ''" :isLoading="isLoadingCurrencyRate"
                label="Receiver gets" placeholder="Amount received" required :max="1000" :min="10" type="number"
                title="convertedAmount" @update:modelValue="convertAmountChanged" />

            <NewActionButton @click="getStarted()" class="custom-action-btn" title="Get Started" />
        </div>


    </div>
</template>


<script>
export default {
    name: 'TransactionBox'
}
</script>

<style lang="scss" scoped></style>
