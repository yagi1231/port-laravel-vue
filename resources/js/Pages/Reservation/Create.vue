<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref } from 'vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import DateList from '@/Components/DateList.vue';
import { getToday } from '@/common';
import dayjs from 'dayjs'
import { computed } from '@vue/reactivity';

const props = defineProps({
    reservation: Object,
    item: Object
})

const itemList = ref([])

onMounted(() => {
    form.day_time = getToday()

    props.item.forEach(item => {
        itemList.value.push({
            id: item.id, name: item.name, price: item.price, quantity: 0
        })
    })
})

const form = reactive({
    name: props.reservation.name,
    customer_id: props.reservation.id,
    kana: props.reservation.kana,
    address: props.reservation.address,
    tel: props.reservation.tel,
    remarks: props.reservation.remarks,
    kana: props.reservation.kana,
    postcode: props.reservation.postcode,
    price: null,
    sumprice: null,
    day_time: null,
    delivery_time: null,
    quantity: null,
    order: null,
    items: []
})

form.sumprice = computed(() => {
    let total = 0
    itemList.value.forEach(item => {
        total += item.price * item.quantity
    })
    return total
})

const dateListTime = (e) => {
    form.delivery_time = e
}

const storeReservation = () => {
    if (confirm('この内容で登録でよろしいでしょうか？')) {
        itemList.value.forEach(item => {
            if (item.quantity > 0) {
                form.items.push({
                    id: item.id,
                    quantity: item.quantity
                })
            }
        })
        Inertia.post('/reservations', form)
    }
}

const quantity = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']
</script>

<template>

    <Head title="顧客登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight bgblue-300">
                顧客登録
            </h2>
        </template>

        <section class="text-gray-600 body-font relative">
            <ValidationErrors class="mb-4" />
            <form @submit.prevent="storeReservation">
                <div class="container px-5 py-8 mx-auto">
                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">名前(カナ)</label>
                                    <div
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        {{ form.name }} ({{ form.kana }})</div>
                                    <!-- <span v-if="!formValidate"
                                        class="list-disc list-inside text-sm text-red-600">20文字以内で入力して下さい</span> -->
                                </div>
                            </div>

                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                                    <div
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        {{ form.tel }}</div>
                                </div>
                            </div>

                            <div class="p-2  w-full">
                                <div class="relative">
                                    <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                    <div
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        〒{{ form.postcode }}<br>{{ form.address }}</div>
                                </div>
                            </div>

                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                メニュー名</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                金額</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                数量</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                小計</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in itemList" :key="item.id">
                                            <td class="px-4 py-3">{{ item.name }}</td>
                                            <td class="px-4 py-3">{{ item.price }}</td>
                                            <select name="quantity" v-model="item.quantity">
                                                <option v-for="q in quantity" :value="q">
                                                    {{ q }}
                                                </option>
                                            </select>

                                            <td class="px-4 py-3">
                                                {{ item.price * item.quantity }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="order" class="leading-7 text-sm text-gray-600">注文</label>
                                    <textarea id="order" name="order" v-model="form.order"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="sumprice" class="leading-7 text-sm text-gray-600">合計金額</label>
                                    <input type="number" id="sumprice" name="sumprice" v-model="form.sumprice"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>

                            <div class="p-2 w-1/">
                                <div class="relative">
                                    <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                    <input type="date" id="date" name="date" v-model="form.day_time"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>

                            <DateList label="時間" @dateList="dateListTime" />

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="remarks" class="leading-7 text-sm text-gray-600">備考欄</label>
                                    <textarea id="remarks" name="remarks" v-model="form.remarks"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <button
                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>

    </AuthenticatedLayout>
</template>