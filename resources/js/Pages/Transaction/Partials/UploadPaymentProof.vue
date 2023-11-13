<script setup>
import FileInput from "@/Components/Custom/FileInput.vue";
import {useAPI} from "@/Composables/useAPI";
import {useNotificationStore} from "@/stores/notification";
import {useHelpers} from "@/Composables/useHelpers";
import {ref} from "vue";
import FiftyText from "@/Components/Design/FiftyText.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";

const props = defineProps({
    url: {
        type: String,
        required: true
    },
    transaction: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['uploaded'])

const api = useAPI();
const notification = useNotificationStore();
const helpers = useHelpers()

const paymentProofUploaded = ref(props.transaction.payment_intent.payment_proof)
const readyToUpload = ref(props.transaction.payment_intent.payment_proof)
const uploadPreviewSrc = ref(props.transaction.payment_intent.payment_proof)
let paymentProofFile = null

const uploadFile = async () => {
    api.startRequest();

    const formData = new FormData();
    formData.append('payment_proof_file', paymentProofFile);
    formData.append('transaction_id', props.transaction.id);
    formData.append('payment_intent_id', helpers.getURLParam('payment-reference-identification'));

    const config = {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    };

    try {
        const res = await axios.post(props.url, formData, config);

        if (res.data.status === 'success') {
            notification.notify('Payment proof uploaded.', 'success');
            emit('uploaded', res.data.transaction);
            paymentProofUploaded.value = true;
        } else {
            notification.notify(res.data.status.message ?? 'Error while uploading.', 'error');
        }

    } catch (errors) {
        api.handleErrors(errors)
        notification.notify('Error while uploading.', 'error');
    } finally {
        api.requestCompleted();
    }

}

const prepareUpload = (paymentProofChosenFile) => {
    readyToUpload.value = true

    if (paymentProofChosenFile) {
        uploadPreviewSrc.value = URL.createObjectURL(paymentProofChosenFile)
        paymentProofFile = paymentProofChosenFile
    }
}

const cancelUpload = () => {
    readyToUpload.value = false
    uploadPreviewSrc.value = ''
    paymentProofFile = null
}

</script>

<template>
    <div>
        <FiftyText variation="body-xl" color="dark" class="mb-4">
            Please, upload a clear image <span class="text-base">(PNG, JPG, SVG)</span> of the payment
            proof.
        </FiftyText>

        <FileInput v-if="!readyToUpload" :isLoading="api.isLoading.value" @file-changed="prepareUpload"/>

        <div v-else class="proof-wrapper">
            <img :src="uploadPreviewSrc" alt="payment proof" class="max-w-sm">

            <div v-if="!paymentProofUploaded" class="action-buttons">
                <NewActionButton
                    :is-loading="api.isLoading.value"
                    @click="uploadFile"
                    title="Upload"
                />

                <NewActionButton
                    :reversed="true"
                    @click="cancelUpload"
                    title="Cancel"
                />
            </div>
        </div>

        <div v-if="api.errors?.value?.payment_proof_file" class="text-left mt-1 text-red-500 text-base">
            {{ api.errors?.value?.payment_proof_file[0] }}
        </div>
    </div>

</template>

<script>
export default {
    name: "UploadPaymentProof"
}
</script>
