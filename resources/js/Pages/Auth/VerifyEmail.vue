<script setup>
import {computed} from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification">
            <title>
                Email Verification
            </title>
        </Head>

        <div class="flex flex-col m-auto mt-32 max-w-sm">
            <div class="mb-4 text-base text-gray-600 dark:text-gray-400">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                link
                we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </div>

            <div v-if="verificationLinkSent" class="mb-4 font-medium text-base text-green-600 dark:text-green-400">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        </div>


        <form class="flex flex-col m-auto mt-8 max-w-sm" @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-start">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Resend Verification Email
                </PrimaryButton>

                <Link
                    :href="route('logout')"
                    as="button"
                    class="ml-6 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none"
                    method="post"
                >Log Out
                </Link
                >
            </div>
        </form>
    </GuestLayout>
</template>
