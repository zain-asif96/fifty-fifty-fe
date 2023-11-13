<script setup>

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false
    },
    header: String,
    close: Function,
    width: String
})

</script>

<template>

    <div>
        <slot name="button"></slot>

        <div v-if="isOpen" aria-labelledby="modal-title" aria-modal="true" class="relative" style="z-index: 999999" role="dialog">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg
                     bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full
                  "
                         :class="{'sm:max-w-6xl': width === 'wide', 'sm:max-w-lg': !width}"
                    >

                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ header }}
                                </h3>
                                <button
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="defaultModal"
                                    type="button"
                                    @click="close">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path clip-rule="evenodd"
                                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                              fill-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-2 space-y-6">
                                <slot name="content"></slot>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
export default {
    name: "Modal"
}
</script>
