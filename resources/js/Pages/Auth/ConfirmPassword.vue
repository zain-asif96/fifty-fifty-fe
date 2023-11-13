<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, useForm} from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password">
            <title>
                Confirm Password
            </title>
        </Head>

        <div class="flex flex-col m-auto mt-32 max-w-sm">
            <div class="mb-4 text-base text-gray-600 dark:text-gray-400">
                This is a secure area of the application. Please confirm your password before continuing.
            </div>
        </div>


        <form class="flex flex-col m-auto mt-8 max-w-sm" @submit.prevent="submit">
            <div>
                <TextInput
                    id="password"
                    v-model="form.password"
                    :errors="form.errors.password ? [form.errors.password] : []"
                    autocomplete="current-password"
                    autofocus
                    class="mt-1 block w-full"
                    label="Password"
                    required
                    title="password"
                    type="password"
                />
            </div>

            <div class="flex justify-start mt-10">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirm
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
