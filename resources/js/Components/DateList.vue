<script setup>
import { ref } from 'vue';

const delivery_time = ref('')

const emit = defineEmits(['dateList'])

const setDateList = (e) => {
    emit('dateList', e)
}

defineProps({
    label: String,
})
</script>

<template>
    <div class="flex">
        <div class="p-2">
            <label for="name" class="leading-7 text-sm text-gray-600">{{ label}}</label><br>
            <input type="text" v-model="delivery_time" @input="setDateList(delivery_time)" min="11:00" max="21:00" list="time-list"
                   class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <datalist id="time-list">
                <option value="11:00-11:30"></option>
                <option value="11:30">前後</option>
                <option value="11:30-12:00"></option>
                <option value="12:00">前後</option>
                <option value="12:00-12:30"></option>
                <option value="12:30">前後</option>
                <option value="12:30-13:00"></option>
                <option value="13:00">前後</option>
                <option value="13:00-13:30"></option>
                <option value="13:30">前後</option>
                <option value="13:30-14:00"></option>
                <option value="14:00">前後</option>
                <option value="14:00-14:30"></option>
                <option value="14:30">前後</option>
                <option value="14:30-15:00"></option>
                <option value="15:00">前後</option>
                <option value="15:00-15:30"></option>
                <option value="15:30">前後</option>
                <option value="15:30-16:00"></option>
                <option value="16:00">前後</option>
                <option value="16:00-16:30"></option>
                <option value="16:30">前後</option>
                <option value="16:30-17:00"></option>
                <option value="17:00">前後</option>
                <option value="17:00-17:30"></option>
                <option value="17:30">前後</option>
                <option value="17:30-18:00"></option>
                <option value="18:00">前後</option>
                <option value="18:00-18:30"></option>
                <option value="18:30">前後</option>
                <option value="18:30-19:00"></option>
                <option value="19:00">前後</option>
                <option value="19:00-19:30"></option>
                <option value="19:30">前後</option>
                <option value="19:30-20:00"></option>
                <option value="20:00">前後</option>
                <option value="20:00-20:30"></option>
                <option value="20:30">前後</option>
                <option value="20:30-21:00"></option>
                <option value="21:00">前後</option>
            </datalist>
        </div>
    </div>
</template>