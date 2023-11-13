<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, useForm} from '@inertiajs/vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password">
            <title>
                Reset Password
            </title>
        </Head>

        <form class="flex flex-col m-auto mt-32 max-w-sm" @submit.prevent="submit">
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

            <TextInput
                id="password"
                v-model="form.password"
                :errors="form.errors.password ? [form.errors.password] : []"
                autocomplete="new-password"
                class="mt-1 block w-full mt-8"
                label="Password"
                required
                title="password"
                type="password"
            />

            <TextInput
                id="password_confirmation"
                v-model="form.password_confirmation"
                :errors="form.errors.password_confirmation ? [form.errors.password_confirmation] : []"
                autocomplete="new-password"
                class="mt-1 block w-full mt-8"
                label="Confirm Password"
                required
                title="password_confirmation"
                type="password"
            />

            <div class="flex items-center justify-start mt-8">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reset Password
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
