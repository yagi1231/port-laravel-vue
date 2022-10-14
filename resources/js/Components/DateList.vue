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
    reactive: String
})
</script>

<template>
    <div :class=class>
        <label for="name" class="leading-7 text-sm text-gray-600">{{ label }}</label><br>
        <select name="status" v-model="delivery_time" @change="setDateList(delivery_time)" :value="props.time"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            list="time-list">
            <option value=""></option>
            <option value="11:00-11:30">11:00-11:30</option>
            <option value="11:30">11:30前後</option>
            <option value="11:30-12:00">11:30-12:00</option>
            <option value="12:00">12:00前後</option>
            <option value="12:00-12:30">12:00-12:30</option>
            <option value="12:30">12:30前後</option>
            <option value="12:30-13:00">12:30-13:00</option>
            <option value="13:00">13:00前後</option>
            <option value="13:00-13:30">13:00-13:30</option>
            <option value="13:30">13:30前後</option>
            <option value="13:30-14:00">13:30-14:00</option>
            <option value="14:00">14:00前後</option>
            <option value="14:00-14:30">14:00-14:30</option>
            <option value="14:30">14:30前後</option>
            <option value="14:30-15:00">14:30-15:00</option>
            <option value="15:00">15:00前後</option>
            <option value="15:00-15:30">15:00-15:30</option>
            <option value="15:30">15:30前後</option>
            <option value="15:30-16:00">15:30-16:00</option>
            <option value="16:00">16:00前後</option>
            <option value="16:00-16:30"></option>
            <option value="16:30">16:30前後</option>
            <option value="16:30-17:00">16:30-17:00</option>
            <option value="17:00">17:00前後</option>
            <option value="17:00-17:30">17:00-17:30</option>
            <option value="17:30">17:30前後</option>
            <option value="17:30-18:00">17:30-18:00</option>
            <option value="18:00">18:00前後</option>
            <option value="18:00-18:30">18:00-18:30</option>
            <option value="18:30">18:30前後</option>
            <option value="18:30-19:00">18:30-19:00</option>
            <option value="19:00">19:00前後</option>
            <option value="19:00-19:30">19:00-19:30</option>
            <option value="19:30">19:30前後</option>
            <option value="19:30-20:00">19:30-20:00</option>
            <option value="20:00">20:00前後</option>
            <option value="20:00-20:30">20:00-20:30</option>
            <option value="20:30">20:30前後</option>
            <option value="20:30-21:00">20:30-21:00</option>
            <option value="21:00">21:00前後</option>
        </select>
    </div>
</template>