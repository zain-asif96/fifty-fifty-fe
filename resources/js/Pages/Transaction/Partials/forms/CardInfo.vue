<script setup>
import { computed, onMounted, reactive, ref, watch } from "vue";
import { useAPI } from "@/Composables/useAPI";
import { useNotificationStore } from "@/stores/notification";
import Spinner from "@/Components/Custom/Spinner.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import NewTextInput from "@/Components/Design/NewTextInput.vue";
import NewSelectInput from "@/Components/Design/NewSelectInput.vue";
import Modal from "@/Components/Custom/Modal.vue";
import { currencies_countries } from "@/helpers/currencies_countries";
import { router, usePage } from "@inertiajs/vue3";

const api = useAPI();
const notification = useNotificationStore();
const geoLocationDetails = usePage().props.geoDetails;
// Props:
const props = defineProps({
    // user: {
    //     type: Object,
    //     required: true
    // },
    user: {
        type: Object,
        required: true
    },
    show: {
        type: Boolean,
        default: false
    }
})
let cardValidation = ref(false)
let cardValidationError = ref('')
const monthNames = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];
let expiryYear = ref()

const expiryYears = computed(() => {
    const currentYear = new Date().getFullYear();
    const numberOfYearsToShow = 10; // Adjust this to show how many future years you want to display
    const years = [];

    for (let i = 0; i < numberOfYearsToShow; i++) {
        let option = { 'label': currentYear + i, 'value': currentYear + i }
        years.push(option);
    }
    return years;
});
let allMonths = computed(() => {
    return monthNames.map((month, index) => ({
        label: month,
        value: (index + 1).toString().padStart(2, '0')
    }));
});
let expiryMonths = ref(allMonths.value);
watch(expiryYear, (newYear) => {
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth() + 1;
    let months = [];
    if (newYear == currentYear) {
        let upcomingMonths = monthNames.slice(currentMonth - 1); // Show upcoming months
        console.log('upcomingMonths', upcomingMonths, currentMonth);
        let j = 0;
        for (let i = 12; i > 12 - upcomingMonths.length; i--) {
            j++
            months.push({ 'label': upcomingMonths[j - 1], 'value': currentMonth + j - 1 });
        }
    } else {
        for (let i = 0; i < monthNames.length; i++) {
            months.push({ 'label': monthNames[i], 'value': i + 1 });
        }

    }
    expiryMonths.value = months
    user.expiry_year = newYear;

});

const user = reactive({
    'amount': '',
    'currency': currencies_countries[geoLocationDetails.country_code],
    'card_number': '',
    'expiry_year': expiryYear.value,
    'expiry_month': '',
    'cvv': '',
    'country': '',
});
onMounted(() => {
    user.amount = props.user.amount;
    user.country = props.user.country
})
console.log('user',user);
const isModalOpened = ref(props.show);
console.log('modal here', isModalOpened.value);
// const closeModal = () => {
//     isModalOpened.value = false;
// }
const openModal = () => {
    console.log('inside openModal ');
    if (props.show) return;
    isModalOpened.value = true;
}


// Emits
const emit = defineEmits(['close'])

function close(isFetchData) {
    console.log('this s iedit', isFetchData);
    emit("close", isFetchData);
}
const goForward = (url) => {
    router.get(url);
}
const cardInfoSubmit = async () => {
    api.startRequest();

    try {
        console.log('user', user);
        const res = await axios.post('/moneris', user);
                console.log('res.data.data.transactionId',res.data.data.transactionId);

        if (res.data.status === 'success') {
            goForward('/transaction-completed?transactionId='+res.data.data.transactionId);

            // goForward('/receiver-info?payment-reference-identification=' + res.data.data.payment_intent_id + '&country=' + user.country);
            notification.notify('Success', 'success');
            close(true);

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
const endEdit = () => {
    api.errors.value = {};
    // currencyData.value = {};
}

function checkCardNo(){
    if (user.card_number.length<16 || user.card_number.length>16 ) {
        cardValidationError.value ="Card number must be 16 digits"
        cardValidation.value =true
    }else{
        cardValidation.value =false
    }
    return {cardValidation, cardValidationError}
}

</script>

<template>
    <div>
        <Modal :close="close" :isOpen="isModalOpened" header="Card Inforamtion">
            <template #content>
                <div class="d-lg-flex d-md-flex d-sm-block">
                    <NewTextInput v-model="user.card_number" :errors="api.errors.value?.card_number" :min="16"
                    label="Card Number" placeholder="Card Number" required title="amount" class="fifty-form-input" type="number"
                    @update:modelValue="checkCardNo"/>
                    <span class="text-danger" v-if="cardValidation">{{ cardValidationError }}</span>
                <NewSelectInput v-model="expiryYear" :errors="api.errors.value?.expiry_year" :options="expiryYears"
                    label="Expiry Year" placeholder="Expiry Year of your payment card" required title="country"
                    class="fifty-form-input" type="text" />
                </div>
                <NewSelectInput v-model="user.expiry_month" :errors="api.errors.value?.expiryMonth"
                    :options="expiryMonths" label="Expiry Month" placeholder="Expiry Month of your payment card" required
                    title="expiry month" class="fifty-form-input" type="text" />
                <NewTextInput v-model="user.cvv" :errors="api.errors.value?.cvv" label="cvv" placeholder="cvv"
                    required title="CVV" class="fifty-form-input" type="number" />


                <div class="flex gap-4 items-center">
                    <!-- <button type="submit" @click="cardInfoSubmit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Submit
                    </button> -->
                    <NewActionButton :isLoading="api.isLoading.value" type="button" title="Continue"
                        @click="cardInfoSubmit" />

                    <button type="button" @click="close"
                        class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Cancel
                    </button>

                    <!-- <Spinner v-if="api.isLoading.value" class="button-spinner-center action-btn" /> -->
                </div>

            </template>

        </Modal>




    </div>
</template>

<style scoped>
select#rate_source {
    height: fit-content;
    border-color: #d9d9d9 !important;
}

.flex.flex-wrap.gap-2.mb-3.justify-content-center {
    justify-content: center;
}
.w-full.flex.flex-col.justify-start.relative.fifty-form-input
{
    margin:auto;
    width:auto;

}
span.text-danger{
    color:red
}
</style>
