<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import FlashMessage from "@/Components/Custom/FlashMessage.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in">
            <title>Log in</title>
        </Head>

        <FlashMessage
            v-if="status"
            :message="status"
            type="success"
        />


        <form class="flex flex-col m-auto mt-32 max-w-sm" @submit.prevent="submit">
            <TextInput
                id="email"
                v-model="form.email"
                :errors="form.errors.email ? [form.errors.email] : []"
                autocomplete="username"
                class="mt-9"
                label="Email"
                placeholder="john@example.com"
                required
                title="email"
                type="email"
            />

            <TextInput
                id="password"
                v-model="form.password"
                :errors="form.errors.password ? [form.errors.password] : []"
                autocomplete="current-password"
                class="mt-1 block w-full mt-8"
                label="password"
                placeholder="***********"
                required
                title="password"
                type="password"
            />

            <div class="block mt-10">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember"/>
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-start mt-8">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="ml-4 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none"
                >
                    Forgot your password?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
