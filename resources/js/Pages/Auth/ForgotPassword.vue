<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, useForm} from '@inertiajs/vue3';
import FlashMessage from "@/Components/Custom/FlashMessage.vue";

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password">
            <title>Forgot Password</title>
        </Head>

        <FlashMessage
            v-if="status"
            :message="status"
            type="success"
        />

        <div class="flex flex-col m-auto mt-32 max-w-sm">
            <div class="mb-0 text-base text-gray-600 dark:text-gray-400">
                Forgot your password? No problem.
                Just let us know your email address and we will email you a password reset link.
            </div>
        </div>

        <form class="flex flex-col m-auto mt-8 max-w-sm" @submit.prevent="submit">
            <div>
                <TextInput
                    id="email"
                    v-model="form.email"
                    :errors="form.errors.email ? [form.errors.email] : []"
                    autocomplete="username"
                    autofocus
                    class="mt-1 block w-full"
                    label="Email"
                    required
                    title="email"
                    type="email"
                />

            </div>

            <div class="flex items-center justify-start mt-12">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Email Password Reset Link
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
