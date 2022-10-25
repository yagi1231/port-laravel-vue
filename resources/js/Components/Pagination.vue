<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { onMounted, ref } from 'vue';
const props = defineProps({ 
    links: Array,
})

const emit = defineEmits(['query'])

const getquery = (e) => {
    const query = {page: e}
    emit('query', query)
}

const url = ref('')

onMounted(() => {
    url.value = location.href.substring(0, location.href.lastIndexOf("=")) + "="
    console.log( url.value )// "="
    if(url.value === "=") {
        url.value = location.href + "?page="
        console.log( url.value )
    }
    else if(url.value.match('&page')) {
        url.value = location.href.substring(0, location.href.indexOf("&page")) + "&page="
        console.log( url.value )
    }
})
</script>
<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, index) in links" :key="index">
                <div v-if="link.url === null" class="mr-1 mb-1 px-3 py-3 text-sm leading-4
                    text-gray-400 border rounded" v-html="link.label" />
                <Link v-else  class="mr-1 mb-1 px-3 py-3 text-sm leading-4 border rounded
                   hover:bg-white focus:border-indigo-500 focus:text-indigo-500" 
                    :class="{ 'bg-blue-700 text-white':link.active }" v-model="url"
                    :href="url + link.label" v-html="link.label"/>
            </template>
        </div>
    </div>
</template>