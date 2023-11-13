<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register">
            <title>Register</title>
        </Head>

        <form class="flex flex-col m-auto mt-24 max-w-sm" @submit.prevent="submit">
            <TextInput
                id="first_name"
                v-model="form.first_name"
                :errors="form.errors.first_name ? [form.errors.first_name] : []"
                autocomplete="first_name"
                autofocus
                class="mt-1 block w-full"
                label="First Name"
                required
                title="first_name"
                type="text"
            />

            <TextInput
                id="last_name"
                v-model="form.last_name"
                :errors="form.errors.last_name ? [form.errors.last_name] : []"
                autocomplete="last_name"
                autofocus
                class="mt-1 block w-full mt-8"
                label="Last Name"
                required
                title="last_name"
                type="text"
            />

            <div class="mt-8">
                <TextInput
                    id="email"
                    v-model="form.email"
                    :errors="form.errors.email ? [form.errors.email] : []"
                    autocomplete="username"
                    class="mt-1 block w-full"
                    label="Email"
                    required
                    title="email"
                    type="email"
                />
            </div>

            <div class="mt-8">

                <TextInput
                    id="password"
                    v-model="form.password"
                    :errors="form.errors.password ? [form.errors.password] : []"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    label="Password"
                    required
                    title="password"
                    type="password"
                />

            </div>

            <div class="mt-8">
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    :errors="form.errors.password_confirmation ? [form.errors.password_confirmation] : []"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    label="Confirm Password"
                    required
                    title="password_confirmation"
                    type="password"
                />

            </div>

            <div class="flex items-center justify-start mt-8">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>

                <Link
                    :href="route('login')"
                    class="ml-4 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none"
                >
                    Already registered?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
