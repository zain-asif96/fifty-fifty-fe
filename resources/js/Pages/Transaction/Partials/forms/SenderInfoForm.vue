<script setup>
import {reactive} from "vue";
import InternationalTelInput from "@/Components/Custom/InternationalTelInput.vue";
import {VueTelInput} from 'vue-tel-input';
import {router, usePage} from "@inertiajs/vue3";
import 'vue-tel-input/dist/vue-tel-input.css';
import {useAPI} from "@/Composables/useAPI";
import NewSelectInput from "@/Components/Design/NewSelectInput.vue";
import {countries} from "@/helpers/countries";
import {useNotificationStore} from "@/stores/notification";
import NewTextInput from "@/Components/Design/NewTextInput.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue"

const props = defineProps({
    transactionId: {
        required: false,
        type: String
    }
})

const api = useAPI();
const notification = useNotificationStore();
const geoLocationDetails = usePage().props.geoDetails;

const user = reactive({
    'first_name': '',
    'country': geoLocationDetails.country_code,
    'last_name': '',
    'email': '',
    'phone': '',
    'flag':'complete_transaction',
})

const verifyUserInformation = async (e) => {
    e.preventDefault();
    api.startRequest();

    try {
        const res = await axios.post('/api/validate-info', {...user, transactionId: props.transactionId});
        if (res.data.status === 'success') router.get('/verify-contacts?source=' + (props.transactionId ?? 'direct'));
    } catch (errors) {
        notification.notify('Something went wrong...', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
};

const phoneCountryChanged = (countryObject) => {
    user.phone = '+' + countryObject.dialCode;
}

// Cancelling:
const cancel = () => {
    router.visit('/');
}

</script>

<template>
    <div class="sender-info-form-wrapper">

        <NewTextInput
            v-model="user.first_name"
            :errors="api.errors.value?.first_name"
            label="First Name"
            placeholder="John"
            required
            title="first_name"
            class="sender-input"
        />

        <NewTextInput
            v-model="user.last_name"
            :errors="api.errors.value?.last_name"
            label="Last Name"
            placeholder="Doe"
            required
            title="last_name"
            class="sender-input"
        />

        <NewTextInput
            v-model="user.email"
            :errors="api.errors.value?.email"
            label="Email"
            placeholder="john@example.com"
            required
            title="email"
            class="sender-input"
        />

        <InternationalTelInput
            :errors="api.errors.value?.phone"
            :required="true"
            label="Phone Number"
            title="phone"
            class="sender-input"
        >
            <vue-tel-input
                id="exampleFormControlInput1"
                ref="input"
                v-model="user.phone"
                :class="{'error-border': api.errors.value?.phone?.length > 0}"
                :defaultCountry="geoLocationDetails?.country_code"
                :inputOptions="{'placeholder': '123456789'}"
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
            v-model="user.country"
            :errors="api.errors.value?.country"
            :options="countries"
            disabled
            label="Country"
            placeholder="Country"
            required
            title="country"
            type="text"
            class="sender-input country"
        />

        <div class="action-buttons">
            <NewActionButton
                :reversed="true"
                type="button"
                title="Cancel"
                @click="cancel"
            />

            <NewActionButton
                :isLoading="api.isLoading.value"
                title="Continue"
                @click="verifyUserInformation"
            />
        </div>

    </div>
</template>

<script>
export default {
    name: "SenderInfo"
}
</script>

