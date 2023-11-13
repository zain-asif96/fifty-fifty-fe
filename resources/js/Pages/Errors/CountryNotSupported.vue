<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Head, Link} from "@inertiajs/vue3";

</script>

<template>

    <Head title="Not Supported | Error">
        <title>
            Not Supported | Error
        </title>
    </Head>

    <GuestLayout>

        <div class="flex justify-center flex-col items-center mt-16">
            <div class="text-4xl mt-16 text-blue-900">
                Sorry, currently Fifty Fifty is not supported in your country.
            </div>

            <p class="mt-16 text-3xl">
                Please check the supported countries list from
                <Link :href="route('services.page', '#supported-countries')"
                      class="mt-8 text-blue-700 hover:underline hover:text-blue-900">
                    Here
                </Link>
            </p>
        </div>


    </GuestLayout>

</template>

<script>
export default {
    name: "CountryNotSupported"
}

</script>
