<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Components/Pagination.vue';
import { onMounted, reactive, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import FlashMessage from '@/Components/FlashMessage.vue';
import DateList from '@/Components/DateList.vue';
import { getToday } from '@/common';

const props = defineProps({
    aggregates: Object
})

const serach = reactive({
    begin: null,
    end: null,
    order: null,
    category: null
})

onMounted(() => {
    // serach.begin = getToday()
    // serach.end = getToday()
})

const serachReservation = () => {
    Inertia.get('/reservations/aggregate', serach)
}
</script>
r
<template>

    <Head title="予約状況" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                予約状況
            </h2>
        </template>

        <FlashMessage />

        <form @submit.prevent="serachReservation">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="flex text-black border-0 py-2 px-6 focus:outline-none rounded w-1/6 justify-center bg-white">
                        検索フォーム</div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-gray-200">
                            <div class="flex justify-center">
                                <div class="p-2">
                                    <label for="name" class="leading-7 text-sm text-gray-600">開始日</label><br>
                                    <input type="date"
                                        class="ml-3 bg-gray-100 bg-opacity-50 rounded border border-gray-300"
                                        name="begin" v-model="serach.begin">
                                </div>

                                <div class="p-2">
                                    <label for="name" class="leading-7 text-sm text-gray-600">終了日</label><br>
                                    <input type="date"
                                        class="ml-3 bg-gray-100 bg-opacity-50 rounded border border-gray-300" name="end"
                                        v-model="serach.end">
                                </div>

                                <div class="p-2">
                                    <label for="category" class="leading-7 text-sm text-gray-600">並び換え</label><br>
                                    <select name="category" class="ml-3 bg-gray-100 bg-opacity-50 rounded border border-gray-300" v-model="serach.category">
                                        <option value=""></option>
                                        <option value="日付">日付</option>
                                        <option value="合計">合計</option>
                                        <option value="平均">平均</option>
                                        <option value="件数">件数</option>
                                    </select>
                                </div>

                                <div class="p-2">
                                    <div class="relative">
                                        <label for="order" class="leading-7 text-sm text-gray-600"></label><br>
                                        <div class="flex mt-3">
                                            <div>
                                                <span class="ml-2">昇順</span>
                                                <input type="radio" id="order" name="order" v-model="serach.order"
                                                    class="ml-2" value="昇順">
                                            </div>

                                            <div>
                                                <span class="ml-2">降順</span>
                                                <input type="radio" id="order" name="order" v-model="serach.order"
                                                    class="ml-2" value="降順">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center mb-5">
                            <button type=reset
                                class="text-black bg-gray-500 border-0 py-2 px-6 focus:outline-none hover:bg-gray-600 rounded ml-3 mb-3">
                                クリア</button>
                            <button
                                class="text-black bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded ml-3 mb-3">
                                検索</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-12 mx-auto">
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                    日付</th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    合計</th>
                                                <th
                                                    class="px-2 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    平均</th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    件数</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="aggregate in aggregates.data" :key="aggregate.id" class=" border-b-2 border-gray-200">
                                                <td class="px-4 py-3">{{ aggregate.time }}</td>
                                                <td class="px-4 py-3">¥{{ Number(aggregate.sumTptal).toLocaleString() }}</td>
                                                <td class="px-4 py-3">¥{{ Math.floor(aggregate.avgTotal).toLocaleString() }}</td>
                                                <td class="px-4 py-3">{{ aggregate.totalCount }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                        <Pagination class="m-6 flex justify-center" :links="aggregates.links"></Pagination>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
