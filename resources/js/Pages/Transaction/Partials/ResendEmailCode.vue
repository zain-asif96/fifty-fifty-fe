<script setup>
import {ref} from "vue";
import {useAPI} from "@/Composables/useAPI";
import {useNotificationStore} from "@/stores/notification";
import Spinner from "@/Components/Custom/Spinner.vue";
import {router} from "@inertiajs/vue3";

const api = useAPI();
const notificationStore = useNotificationStore();
const time = ref(parseInt(window.sessionStorage.getItem('resend-timer')) ?? 60)

const resendEmailCode = async () => {
    if (time.value > 0) return;

    api.startRequest();

    try {
        const res = await axios.post('/api/resend-email-code');

        if (res.data.status === 'success') {
            resetTimer();
            notificationStore.notify('Email Sent.', 'success');
        } else if (res.data.status === 'redirect') {
            notificationStore.notify('Session has expired!', 'error');
            setTimeout(() => {
                router.get('/user-info')
            }, 1000);
        } else {
            notificationStore.notify('Unexpected error happened', 'error');
        }
    } catch (errors) {
        let message = 'Invalid code';
        if (errors.response.status === 419) {
            router.get('/user-info', {'message': 'session expired'}, {preserveState: false});
            message = 'Session expired, please reload the page';
            setTimeout(() => {
                window.location = '/user-info';
            }, 1000);
        }
        api.handleErrors(errors)
        notificationStore.notify(message, 'error');
    } finally {
        api.requestCompleted()
    }
}

const resetTimer = () => {
    time.value = 60;
    window.sessionStorage.setItem('resend-timer', time.value);
}

const downTimer = setInterval(() => {
    time.value--;
    window.sessionStorage.setItem('resend-timer', time.value);
    if (time.value === 0) clearInterval(downTimer);
}, 1000);

</script>

<template>
    <div class="resend-code-wrapper">
        <button :class="{ 'opacity-50 hover:cursor-not-allowed': time > 0 }" @click="resendEmailCode">
            Resend
        </button>

        <div class="time">
            {{ time > 0 ? 'code in ' + time : '' }}
            <Spinner class="ml-2" v-if="api.isLoading.value" :isLoading="api.isLoading.value"/>
        </div>
    </div>

</template>

<script>
export default {
    name: 'ResendEmailCode'
}
</script>
