<script setup>
import { onMounted, ref } from 'vue';

const delivery_time = ref(props.reactive)

const emit = defineEmits(['dateList'])

const setDateList = (e) => {
    emit('dateList', e)
}

const props = defineProps({
    label: String,
    class: String,
    reactive: String,
    time: Array,
})
</script>

<template>
    <div :class=class>
        <label for="name" class="leading-7 text-sm text-gray-600">{{ label }}</label><br>
        <select name="status" v-model="delivery_time" @change="setDateList(delivery_time)"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            list="time-list">
            <option  v-for="t in time" :key="t.time">
                {{ t }}
            </option>
        </select>
    </div>
</template>