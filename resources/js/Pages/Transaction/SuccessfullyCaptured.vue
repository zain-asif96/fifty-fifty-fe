<script>
export default {
    name: 'SuccessfullPayment'
}
</script>
<script setup>
import {Head} from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

</script>

<template>
    <GuestLayout>
        <Head title="Fifty-Fifty | Send Money">
            <title>
                Fifty-Fifty | Payment success
            </title>
        </Head>

        <main>
            <div class="relative px-6 lg:px-8">
                <div class="text-center mx-auto max-w-2xl py-24 sm:py-32 lg:py-32">

                    <div class="text-3xl text-green-800 text-center">
                        Thank you! We have authorized your card successfully
                    </div>

                    <div class="text-3xl text-green-500 text-center mt-16">
                        A post with your transaction has been published!
                    </div>

                    <button class="text-xl text-blue-700 mt-16 bg-gray-100 p-4 rounded-md">
                        Track your transaction
                    </button>

                </div>
            </div>
        </main>
    </GuestLayout>
</template>
