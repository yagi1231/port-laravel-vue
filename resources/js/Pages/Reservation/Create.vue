<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref } from 'vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import DateList from '@/Components/DateList.vue';
import { getToday } from '@/common';
import { computed } from '@vue/reactivity';
import { useField, useForm } from "vee-validate";
import { object, date } from 'yup';


const props = defineProps({
    reservation: Object,
    item: Object,
    times: Array
})

const itemList = ref([])

onMounted(() => {
    props.item.forEach(item => {
        itemList.value.push({
            id: item.id, name: item.name, price: item.price, quantity: 0
        })
    })
})

const form = reactive({
    sumprice: null,
    delivery_time: null
})

///datelistからのeimt
const dateListTime = (e) => {
    form.delivery_time = e
}

///数量用の配列
const quantity = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']

const schema = object({
    day_time: date().required('番地・　住所は必須です').typeError('日付を入力してください').label('日付'),
});

const { errors, meta, handleChange, handleSubmit, isSubmitting } = useForm({
    validationSchema: schema,
    initialValues: {
        name: props.reservation.name,
        customer_id: props.reservation.id,
        kana: props.reservation.kana,
        tel: props.reservation.tel,
        remarks: props.reservation.remarks ?? '',
        postcode: props.reservation.postcode,
        address: props.reservation.address,
        after_address: props.reservation.affter_address,
        status: '準備中',
        sumprice: '',
        day_time: getToday(),
        delivery_time: '',
        items: []
    },
});

const { value: name } = useField("name");
const { value: tel } = useField('tel');
const { value: kana } = useField("kana");
const { value: postcode } = useField('postcode');
const { value: after_address } = useField("after_address");
const { value: address } = useField("address");
const { value: remarks } = useField('remarks');
const { value: day_time } = useField("day_time");
const { value: delivery_time } = useField('delivery_time');

///合計金額の計算
form.sumprice = computed(() => {
    let total = 0
    itemList.value.forEach(item => {
        total += item.price * item.quantity
    })
    return total
})

const storeReservation = handleSubmit((values) => {
    if (confirm('この内容で登録でよろしいでしょうか？')) {
        itemList.value.forEach(item => {
            if (item.quantity > 0) {
                values.items.push({
                    id: item.id,
                    quantity: item.quantity
                })
            }
        })
        values.sumprice = form.sumprice
        values.delivery_time = form.delivery_time

        Inertia.post('/reservations', values)
    }
})
// const storeCustomer = handleSubmit((values) => {
//     values.address = form.address
//     if (confirm('この内容で登録でよろしいでしょうか？')) {
//         Inertia.post('/customers', values)
//     }
// });
</script>

<template>

    <Head title="予約情報登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight bgblue-300">
                予約情報登録
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
                                        {{ name }} ({{ kana }})</div>
                                </div>
                            </div>

                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                                    <div
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        {{ tel }}</div>
                                </div>
                            </div>

                            <div class="p-2  w-full">
                                <div class="relative">
                                    <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                    <div
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <span> 〒{{ postcode }}</span><br>
                                        <span>{{ address }} </span>
                                        <span>{{ after_address }}</span>
                                    </div>
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
                                            <select name="quantity" v-model="item.quantity" class="bg-gray-100">
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
                                    <label for="sumprice" class="leading-7 text-sm text-gray-600">合計金額</label>
                                    <input type="number" id="sumprice" name="sumprice" v-model="form.sumprice" readonly
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>

                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                    <input type="date" id="date" name="date" v-model="day_time"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <p style="color: red;">{{ errors.day_time }}</p>
                                </div>
                            </div>

                            <DateList label="時間" class="p-2 w-1/2" :time="props.times" @dateList="dateListTime"
                                v-model="delivery_time" />

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="remarks" class="leading-7 text-sm text-gray-600">備考欄</label>
                                    <div id="remarks" name="remarks"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                                        {{ remarks }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <button :disabled="!meta.valid || isSubmitting" v-if="meta.valid"
                                    class="validate-color flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                                <button :disabled="!meta.valid || isSubmitting" v-else
                                    class="validate-color flex mx-auto text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none rounded text-lg">登録</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </AuthenticatedLayout>
</template>