<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { reactive, onMounted } from 'vue'
import { getToday } from '@/common'
import Chart from '@/Components/Chart.vue'
import dayjs from 'dayjs'

const getData = async () => {
    try {
        await axios.get('/api/analysis/', {
            params: {
                startDate: form.startDate,
                endDate: form.endDate,
                type: form.type,
                category: form.category,
            }
        })
            .then(res => {
                data.value = res.data.data
                data.labels = res.data.labels
                data.totals = res.data.totals
                data.title = res.data.title
                data.type = res.data.type
                console.log(res.data.data)
            })
    } catch (e) {
        console.log(e.message)
    }
}

onMounted(() => {
    form.startDate = getToday(), form.endDate = getToday()
})

const data = reactive({})

const form = reactive({
    startDate: null,
    endDate: null,
    type: 'perDay',
    category: '合計'
}) 
</script>

<template>

    <Head title="集計" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl z leading-tight bgblue-300">
                集計
            </h2>
        </template>

        <form @submit.prevent="getData">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">ïï
                    <div class="p-6 bg-white border-gray-200">
                        <div class="flex justify-center">
                            <div class="p-2">
                                <label for="name" class="leading-7 text-sm text-gray-600">begin</label><br>
                                <input type="date" name="startDate" v-model="form.startDate"
                                    class="ml-3 bg-gray-100 bg-opacity-50 rounded border border-gray-300">
                            </div>

                            <div class="p-2">
                                <label for="name" class="leading-7 text-sm text-gray-600">end</label><br>
                                <input type="date" name="endDate" v-model="form.endDate"
                                    class="ml-3 bg-gray-100 bg-opacity-50 rounded border border-gray-300">
                            </div>

                            <div class="p-2">
                                <label for="category" class="leading-7 text-sm text-gray-600">集計内容</label><br>
                                <select name="category"
                                    class="ml-3 bg-gray-100 bg-opacity-50 rounded border border-gray-300"
                                    v-model="form.category">
                                    <option value="合計">合計</option>
                                    <option value="平均">平均</option>
                                    <option value="件数">件数</option>
                                </select>
                            </div>

                            <div class="p-2">
                                <div class="relative">
                                    <label for="order" class="leading-7 text-sm text-gray-600">検索内容</label><br>
                                    <div class="flex mt-3">
                                        <div>
                                            <span class="ml-2">日別</span>
                                            <input type="radio" id="order" name="sort" v-model="form.type" class="ml-2"
                                                value="perDay">
                                        </div>

                                        <div>
                                            <span class="ml-2">月別</span>
                                            <input type="radio" id="order" name="sort" v-model="form.type" class="ml-2"
                                                value="perMonth">
                                        </div>

                                        <div>
                                            <span class="ml-2">年別</span>
                                            <input type="radio" id="order" name="sort" v-model="form.type" class="ml-2"
                                                value="perYear">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center mt-5">
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

                        <div>
                            <Chart :data="data" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                            日付
                                        </th>
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            合計売上
                                        </th>
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            平均売上
                                        </th>
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            件数
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in data.value" :key="item.date" class=" border-b-2 border-gray-200">
                                        <td class="px-4 py-3">{{ dayjs(item.time).format('YYYY/MM/DD') }}</td>
                                        <td class="px-4 py-3">¥{{ Number(item.total).toLocaleString() }}</td>
                                        <td class="px-4 py-3">¥{{ Math.floor(item.average).toLocaleString() }}</td>
                                        <td class="px-4 py-3">{{ item.count }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
