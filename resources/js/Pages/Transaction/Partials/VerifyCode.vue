<script setup>
import {ref} from "vue";
import {useNotificationStore} from "@/stores/notification";
import {useAPI} from "@/Composables/useAPI";
import ResendEmailCode from "@/Pages/Transaction/Partials/ResendEmailCode.vue";
import {router} from "@inertiajs/vue3";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import NewTextInput from "@/Components/Design/NewTextInput.vue";


const api = useAPI();

const props = defineProps({
    user: {
        default: null,
        type: Object
    }
})

const emit = defineEmits(['verified'])
let isVerified = ref(!!props.user.email_verified_at || !!props.user.phone_verified_at)
const verificationCode = ref('');

// Notification:
const notificationStore = useNotificationStore();


const verifyEmailCode = async () => {
    api.startRequest();
    try {
        const res = await axios.post('/api/verify-user', {
            code: verificationCode.value,
        });
        console.log('res',res);
        if (res.data.status === 'valid') {
            isVerified.value = true;
            console.log('isVerified',isVerified.value);
            notificationStore.notify('Verified', 'success');
            emit('verified');


        } else {
            api.errors.value.verificationCode = ['Invalid code'];
            notificationStore.notify('Invalid code', 'error');
        }
    } catch (errors) {
        let message = 'Invalid code';
        if (errors.response.status === 419) {
            router.get('/user-info', {'message': 'session expired'}, {preserveState: false});
            message = 'Session expired, please reload the page.';
            setTimeout(() => {
                window.location = '/user-info';
            }, 1000);
        }
        notificationStore.notify(message, 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted()
    }
}

</script>

<template>
    <div class="verify-code-form-wrapper">
        <div class="code-input">
            <NewTextInput
                v-model="verificationCode"
                :errors="api.errors.value?.code"
                label="Verification code"
                placeholder="6-digit code"
                required
                title="verificationCode"
            />

            <ResendEmailCode  />
        </div>

        <div class="action-buttons">
            <NewActionButton
                title="Back"
                :reversed="true"
                @click="router.get('/user-info')"
            />

            <NewActionButton
                title="Verify"
                :isLoading="api.isLoading.value"
                :disabled="isVerified==true?'disabled':''"
                @click="verifyEmailCode"
            />
        </div>
    </div>
</template>
<script>
export default {
    name: 'VerifyCode'
}
</script>
