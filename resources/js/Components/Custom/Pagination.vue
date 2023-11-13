<template>
    <div v-if="links.length > 3" class="mt-6 mb-4">
        <div class="flex flex-wrap mb-1">
            <template v-for="(link, k) in links" :key="k">
                <div v-if="link.url === null" class="mr-1 mb-1 px-3 py-2 text-sm leading-4 text-gray-400 border rounded"
                     v-html="link.label"></div>

                <Link v-else
                      :class="{ 'bg-gray-600 text-white': link.active }"
                      :href="`${link.url}&q=${search ?? ''}&column=${column ?? ''}&type=${type ?? ''}`"
                      class="mr-1 mb-1 px-3 py-2 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                      v-html="link.label"
                ></Link>
            </template>
        </div>
    </div>
</template>

<script>
import {Link} from '@inertiajs/vue3'

export default {
    name: "Pagination",
    components: {
        Link
    },
    props: {
        links: Array,
    },
    data() {
        return {
            search: "",
            column: "id",
            type: "asc",
        }
    },
    mounted() {
        this.search = new URLSearchParams(window.location.search).get('q');
        this.column = new URLSearchParams(window.location.search).get('column');
        this.type = new URLSearchParams(window.location.search).get('type');
    }
}
</script>

<style scoped>

</style>
