<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs'
import { onMounted } from 'vue';

const props = defineProps({
    purchase: Object,
    totalPurchases: Object
})
</script>

<template>

    <Head title="購入履歴詳細" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                購入履歴詳細
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-8 mx-auto">
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="name" class="leading-7 text-sm text-gray-600">購入日</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ dayjs(props.totalPurchases.time).format('YYYY/MM/DD') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="price" class="leading-7 text-sm text-gray-600">お客様名</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ props.totalPurchases.reservation_name }}様
                                                </div>
                                            </div>
                                        </div>

                                        <div class="lg:w-full w-full mx-auto overflow-auto mt-5">
                                            <table class="table-auto w-full text-left whitespace-no-wrap">
                                                <thead>
                                                    <label for="price"
                                                        class="leading-7 text-sm text-gray-600">注文内容</label>
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
                                                    <tr v-for="item in purchase" :key="item.id">
                                                        <td class="px-4 py-3">{{ item.item_name }}</td>
                                                        <td class="px-4 py-3">{{ item.item_price }}</td>
                                                        <td class="px-4 py-3">{{ item.quantity }}</td>
                                                        <td class="px-4 py-3"> {{ Number(item.item_price * item.quantity).toLocaleString()  }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="price" class="leading-7 text-sm text-gray-600">合計金額</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ Number(props.totalPurchases.total).toLocaleString() }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="price" class="leading-7 text-sm text-gray-600">ステータス</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ props.totalPurchases.status }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="price"
                                                    class="leading-7 text-sm text-gray-600">キャンセル日</label>
                                                <div v-if="props.totalPurchases.deleted_at"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ dayjs(props.totalPurchases.deleted_at).format('YYYY/MM/DD') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-center mt-5">
                                    <div class="p-2 w-1/10">
                                        <Link as="button" :href="route('reservations.edit', { reservation:  props.totalPurchases.id})" 
                                             v-if="!props.totalPurchases.deleted_at"
                                            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                                        購入履歴編集</Link>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>