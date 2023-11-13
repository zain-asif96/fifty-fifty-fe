<script setup>

defineProps({
    receiver: {
        required: true,
        type: Object
    },
    useSavedReceiver: {
        required: true,
        type: Function
    }
})

</script>

<template>
    <div
        class="text-left mt-4 block max-w-xl p-3 bg-white border border-gray-200 rounded-lg
                 shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-200">

        <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
            <div>
                First name: <b> {{ receiver.first_name }}</b>
            </div>
            <div>
                Last name: <b> {{ receiver.last_name }}</b>
            </div>
            <div>
                Email: <b> {{ receiver.email }}</b>
            </div>
            <div>
                Phone: <b> {{ receiver.phone }}</b>
            </div>
            <div>
                Country: <b> {{ receiver.country }}</b>
            </div>
        </div>


        <button class="text-xl text-white
                hover:bg-indigo-500
                bg-indigo-600 px-4 py-1 rounded mt-4"
                @click="useSavedReceiver(receiver)">
            Use
        </button>
    </div>
</template>

<script>
export default {
    name: 'ReceiverItem'
}
</script>
