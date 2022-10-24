<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Components/Pagination.vue';
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import FlashMessage from '@/Components/FlashMessage.vue';
import dayjs from 'dayjs'

defineProps({
    items: Object,
    status: Array
})

const serachItem = () => {
    Inertia.get('items', serach)
}

const serach = reactive({
    inputingName: null,
    status: '販売中'
})
</script>

<template>

    <Head title="商品一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品一覧
            </h2>
        </template>

        <FlashMessage />

        <form @submit.prevent="serachItem">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="p-6 bg-white border-gray-200">
                        <div class="flex justify-center mb-5">
                            <div class="">
                                <label class="leading-7 text-sm text-gray-600">メニュー名</label><br>
                                <input type="text"
                                    class="w-4/5 ml-3 bg-gray-100 bg-opacity-50 rounded border border-gray-300"
                                    name="name" v-model="serach.inputingName">
                            </div>

                            <div class="sm:w-full md:w-1/6">
                                <label for="tel" class="leading-7 text-sm text-gray-600">ステータス</label><br>
                                <select name="status" v-model="serach.status"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <option v-for="s in status">{{s}}</option>
                                </select>
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
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-12 mx-auto">
                                <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                                    <Link as="button" :href="route('items.create')"
                                        class="flex ml-auto text-black bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded mb-3">
                                    新規登録</Link>
                                </div>
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                    メニュー名</th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    金額</th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    ステータス</th>
                                                <th
                                                    class="p-4 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                                    更新日</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in items.data" :key="item.id"
                                                class=" border-b-2 border-gray-200">
                                                <td class="px-4 py-3">
                                                    <Link class="text-blue-400"
                                                        :href="route('items.show', { item: item.id })">
                                                    {{ item.name }}
                                                    </Link>
                                                </td>
                                                <td class="px-4 py-3">{{ item.price}}</td>
                                                <td class="px-4 py-3">{{ item.status }}</td>
                                                <td class="px-4 py-3">{{ dayjs(item.updated_at).format('YYYY-MM-DD') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                        <Pagination class="m-6 flex justify-center" :links="items.links"></Pagination>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
