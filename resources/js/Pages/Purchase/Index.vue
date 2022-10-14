<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Components/Pagination.vue';
import { onMounted, reactive, ref } from 'vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import dayjs from 'dayjs'
import { Inertia } from '@inertiajs/inertia';

defineProps({
    purchases: Object
})

const serach = reactive({
    dateTime: null,
    name: null,
})

const serachPurchase = () => {
    Inertia.get('/purchases', serach)
}
</script>

<template>

    <Head title="購買履歴" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                購買履歴
            </h2>
        </template>

        <FlashMessage />

        <form @submit.prevent="serachPurchase">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="p-6 bg-white border-gray-200">
                        <div class="flex justify-center">
                            <div class="p-2">
                                <label for="date" class="leading-7 text-sm text-gray-600">日付検索</label><br>
                                <input type="date" class="ml-3 bg-gray-100 bg-opacity-50 rounded border border-gray-300"
                                    name="date" v-model="serach.dateTime">
                            </div>

                            <div class="p-2 w-1/3">
                                <label for="name" class="leading-7 text-sm text-gray-600">顧客名</label><br>
                                <input type="text"
                                    class="ml-3 w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300"
                                    name="tel" v-model="serach.name">
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
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                    購入者</th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    金額</th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    ステータス</th>
                                                <th
                                                    class="p-4 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                                    購入日</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="purchase in purchases.data" :key="purchase.id"
                                                class=" border-b-2 border-gray-200">
                                                <td class="px-4 py-3">
                                                    <Link class="text-blue-400"
                                                        :href="route('purchases.show', { id: purchase.id })">
                                                    {{ purchase.reservation_name }}
                                                    </Link>
                                                </td>
                                                <td class="px-4 py-3">{{ Number(purchase.total).toLocaleString() }}</td>
                                                <td class="px-4 py-3">{{ purchase.reservation_name }}</td>
                                                <td class="px-4 py-3">{{ dayjs(purchase.time).format('YYYY/MM/DD') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                        <Pagination class="m-6 flex justify-center" :links="purchases.links"></Pagination>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
