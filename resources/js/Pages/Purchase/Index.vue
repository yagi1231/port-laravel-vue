<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Components/Pagination.vue';
import { onMounted, reactive, ref } from 'vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import dayjs from 'dayjs'

defineProps({
    purchases: Object
})
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
                                            <tr v-for="purchase in purchases.data" :key="purchase.id">
                                                <td class="px-4 py-3">
                                                    <Link  class="text-blue-400" :href="route('purchases.show', { id: purchase.id })">
                                                        {{ purchase.reservation_name }}
                                                    </Link>
                                                </td>
                                                <td class="px-4 py-3">{{ purchase.total}}</td>
                                                <td class="px-4 py-3">{{ purchase.reservation_name }}</td>
                                                <td class="px-4 py-3">{{ dayjs(purchase.time).format('YYYY/MM/DD')  }}</td>
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
