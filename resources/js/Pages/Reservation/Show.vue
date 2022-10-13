<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs'
import { nl2br } from '@/common.js'

const props = defineProps({
    reservation: Object,
    createStaffName: Object,
    updateStaffName: Object
})

const deleteReservation = (id) => {
    if (confirm('本当に削除してもよろしいでしょうか？')) {
        Inertia.delete(route('reservations.destroy', { reservation: id }))
    }
}

</script>

<template>

    <Head title="顧客詳細" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                顧客詳細
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-8 mx-auto">

                                <div class="flex justify-end mb-5">
                                    <div class="p-2 w-1/6">
                                        <div class="relative">
                                            <label class="leading-7 text-sm text-gray-600">ステータス:</label>
                                            <div
                                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ reservation.status }}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="p-2 w-1/6">
                                        <div class="relative">
                                            <label class="leading-7 text-sm text-gray-600">更新日時:</label>
                                            <div 
                                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ dayjs(reservation.updated_at).format('YYYY/MM/DD') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-2 w-1/5">
                                        <div class="relative">
                                            <label class="leading-7 text-sm text-gray-600">最終更新者:</label>
                                            <div
                                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{  updateStaffName.name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-1/2">
                                            <div class="relative">
                                                <label class="leading-7 text-sm text-gray-600">商品名</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ reservation.name }} ( {{ reservation.kana }} )
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-1/2">
                                            <div class="relative">
                                                <label class="leading-7 text-sm text-gray-600">金額</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ reservation.tel }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label class="leading-7 text-sm text-gray-600">住所</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    〒{{ reservation.postcode }}<br>{{ reservation.address }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label class="leading-7 text-sm text-gray-600">注文内容</label>
                                                <div v-html="nl2br(reservation.order)"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-1/2">
                                            <div class="relative">
                                                <label class="leading-7 text-sm text-gray-600">金額</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ reservation.sumprice }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-1/2">
                                            <div class="relative">
                                                <label class="leading-7 text-sm text-gray-600">金額</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ reservation.sumprice }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-1/2">
                                            <div class="relative">
                                                <label class="leading-7 text-sm text-gray-600">日付</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ reservation.time }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-1/2">
                                            <div class="relative">
                                                <label class="leading-7 text-sm text-gray-600">時間</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ reservation.datetime }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-1/2">
                                            <div class="relative">
                                                <label class="leading-7 text-sm text-gray-600">注文受付者</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ createStaffName.name }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-1/2">
                                            <div class="relative">
                                                <label class="leading-7 text-sm text-gray-600">注文受付日</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ dayjs(reservation.created_at).format('YYYY/MM/DD') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label class="leading-7 text-sm text-gray-600">備考欄</label>
                                                <div v-html="nl2br(reservation.remarks)"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="flex justify-center mt-5">
                                    <div class="p-2 w-1/10">
                                        <Link as="button"
                                            :href="route('reservations.edit', { reservation: reservation.id})"
                                            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                                        編集</Link>
                                    </div>

                                    <div class="p-2 w-1/10">
                                        <button @click.prevent="deleteReservation(reservation.id)"
                                            class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除</button>
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