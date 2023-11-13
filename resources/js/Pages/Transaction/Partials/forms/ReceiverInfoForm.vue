<script setup>
import {onMounted, reactive, ref} from "vue";
import {useAPI} from "@/Composables/useAPI";
import {VueTelInput} from 'vue-tel-input';
import 'vue-tel-input/dist/vue-tel-input.css';
import InternationalTelInput from "@/Components/Custom/InternationalTelInput.vue";
import {useNotificationStore} from "@/stores/notification";
import ReceiverItem from "@/Pages/Transaction/Partials/ReceiverItem.vue";
import {router} from "@inertiajs/vue3";
import {useHelpers} from "@/Composables/useHelpers";
import {countries} from "@/helpers/countries";
import {countryCodes} from "@/helpers/countryCodes";
import NewSelectInput from "@/Components/Design/NewSelectInput.vue"
import NewActionButton from "@/Components/Design/NewActionButton.vue"
import NewTextInput from "@/Components/Design/NewTextInput.vue"
import NewTextArea from "@/Components/Design/NewTextArea.vue";

const emit = defineEmits(['stepChanged'])
const notification = useNotificationStore();
const helpers = useHelpers();
const api = useAPI();
const props = defineProps({
    user: {
        default: null,
        type: Object
    },
    latestReceivers: {
        default: [],
        type: Array
    },
    banks: {
        default: [],
        type: Array
    }
})


const paymentIntentID = ref('');
const isTransactionPreset = ref(false);

const selectedCountry = reactive({
    label: '',
    value: ''
});

const receiver = reactive({
    'first_name': '',
    'last_name': '',
    'phone': '',
    'email': '',
    'country': '',
    'bank': '',
    'account_number': '',
    'branch_number': '',
    'banking_info': ''
})

const saveReceiver = async () => {
    api.startRequest();

    try {
        const res = !receiver.id ?
            await axios.post(`/api/${props.user.id}/receiver`, {...receiver, 'paymentIntentId': paymentIntentID.value})
            : await axios.put(`/api/receiver/${receiver.id}`, {...receiver, 'paymentIntentId': paymentIntentID.value});

        if (res.data.id || res.data.status === 'success') {
            notification.notify('Receiver Information Saved', 'success');
            goForward()
        }
    } catch (errors) {
        notification.notify('Error', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
}

const goForward = () => {
    router.get('/checkout?payment-reference-identification=' + paymentIntentID.value + '&country=' + selectedCountry.value.value)
}


const goBack = () => {
    router.get('/transaction-info')
}

const useSavedReceiver = (savedReceiver) => {
    selectedCountry.value = countries.find((countryObject) => {
        return countryObject.value === savedReceiver.country
            || countryObject.value === countryCodes[savedReceiver.country];
    });
    Object.assign(receiver, savedReceiver)
}


const phoneCountryChanged = (countryObject) => {
    const oldNumber = receiver.phone?.slice(countryObject.dialCode.length + 1)
    receiver.phone = '+' + countryObject.dialCode + oldNumber;
}

const setReceiverValues = () => {
    receiver.country = props.user.handled_transaction.user.country;
}

onMounted(() => {
    paymentIntentID.value = helpers.getURLParam('payment-reference-identification');
    console.log('paymentIntentID.value',paymentIntentID.value);
    const paramCountry = helpers.getURLParam('country');

    console.log(paramCountry);

    selectedCountry.value = countries.find((countryObject) => {
        return countryObject.value === paramCountry;
    });

    receiver.country = selectedCountry.value?.value;

    isTransactionPreset.value = !!props.user.transaction_id;

    if (isTransactionPreset.value) {
        setReceiverValues();
    }
})

</script>

<template>
    <div>
        <div class="receiver-info-form-wrapper">
            <NewTextInput
                class="fifty-form-input"
                v-model="receiver.first_name"
                :errors="api.errors.value?.first_name"
                label="First Name"
                placeholder="John"
                required
                title="first_name"
            />
            <NewTextInput
                class="fifty-form-input"
                v-model="receiver.last_name"
                :errors="api.errors.value?.last_name"
                label="Last Name"
                placeholder="Doe"
                required
                title="last_name"
            />
            <NewTextInput
                class="fifty-form-input"
                v-model="receiver.email"
                :errors="api.errors.value?.email"
                label="Email"
                placeholder="john@example.com"
                title="email"
            />
            <InternationalTelInput
                :errors="api.errors.value?.phone"
                :required="false"
                label="Phone Number"
                title="phone"
                class="fifty-form-input"
            >
                <vue-tel-input
                    id="exampleFormControlInput1"
                    ref="input"
                    v-model="receiver.phone"
                    :class="{'error-border': api.errors.value?.phone?.length > 0}"
                    :defaultCountry="helpers.getURLParam('country')"
                    :inputOptions="{'placeholder': '123456789'}"
                    :onlyCountries="isTransactionPreset ? [receiver.country] : []"
                    class="form-control block w-full px-0 py-0 text-lg font-normal h-10
              text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition
              ease-linear m-0
              focus:text-gray-700 focus:bg-white focus:border-indigo-300 focus:outline-none"
                    mode="international"
                    @country-changed="phoneCountryChanged"
                >

                </vue-tel-input>
            </InternationalTelInput>
            <NewSelectInput
                class="fifty-form-input"
                v-model="receiver.country"
                :errors="api.errors.value?.country"
                :options="countries"
                disabled
                label="Country"
                placeholder="Country"
                required
                title="country"
                type="text"
            />
            <NewSelectInput
                class="fifty-form-input"
                v-model="receiver.bank_id"
                :errors="api.errors.value?.bank_id"
                :options="banks"
                label="International Bank"
                label-accessor="label"
                placeholder="International Bank"
                required
                title="bank"
                type="text"
                value-accessor="id"
            />
            <NewTextInput
                class="fifty-form-input"
                v-model="receiver.account_number"
                :errors="api.errors.value?.account_number"
                label="Account Number"
                placeholder="123456789"
                required
                title="account_number"
            />
            <NewTextInput
                class="fifty-form-input"
                v-model="receiver.branch_number"
                :errors="api.errors.value?.branch_number"
                label="Branch Number"
                placeholder="123456789"
                title="branch_number"
            />
            <NewTextArea
                v-model="receiver.banking_info"
                :errors="api.errors.value?.banking_info"
                label="Additional Information / Comments"
                placeholder="I am open to different payment options..."
                title="banking_info"
            />

            <div class="action-buttons">
                <NewActionButton
                    :reversed="true"
                    title="Back"
                    @click="goBack"
                />

                <NewActionButton
                    :isLoading="api.isLoading.value"
                    title="Continue"
                    @click="saveReceiver"
                />
            </div>
        </div>

        <div v-if="latestReceivers.length > 0" class="text-center">
            <div class="mt-6 mb-6 text-2xl text-green-800 font-semibold">
                Recently Added Receivers
            </div>

            <div class="flex flex-wrap gap-5 max-w-3xl">
                <ReceiverItem v-for="oldReceiver in latestReceivers" :key="oldReceiver.id"
                              :receiver="oldReceiver" :useSavedReceiver="useSavedReceiver"/>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ReceiverInfoForm'
}
</script>
