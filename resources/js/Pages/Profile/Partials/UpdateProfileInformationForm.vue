<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Link, useForm, usePage} from '@inertiajs/vue3';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.auth.user;

const form = useForm({
    first_name: user.first_name,
    last_name: user.last_name,
    email: user.email,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Account Information</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>

        <form class="mt-6 space-y-6" @submit.prevent="form.patch(route('profile.update'))">
            <div>
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
            </div>

            <div>
                <TextInput
                    id="name"
                    v-model="form.last_name"
                    :errors="form.errors.last_name ? [form.errors.last_name] : []"
                    autocomplete="name"
                    autofocus
                    class="mt-1 block w-full"
                    label="Last Name"
                    required
                    title="last_name"
                    type="text"
                />

            </div>

            <div>
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

            <div v-if="props.mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        as="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        method="post"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="props.status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition class="transition ease-in-out" enter-from-class="opacity-0" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
