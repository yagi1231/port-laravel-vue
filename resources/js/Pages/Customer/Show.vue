<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref } from 'vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import { Core as YubinBangoCore } from "yubinbango-core2";
import * as AutoKana from "vanilla-autokana";
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
    customer: Object,
    staff: Object,
    lastOrderDay: Object,
    orderCount: Number,
})

const form = props.customer

const pushReservation = () => {
    Inertia.get(route('reservations.create'), form)
}

const deleteCustomer = (id) => {
    if (confirm('本当に削除してもよろしいでしょうか？')) {
        Inertia.delete(route('customers.destroy', { customer: id }))
    }
}

onMounted(() => {
})

</script>

<template>

    <Head title="顧客詳細" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                顧客詳細
            </h2>
        </template>

        <FlashMessage />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-8 mx-auto">
                                <div class="flex justify-end mb-5">

                                </div>

                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="name"
                                                    class="leading-7 text-sm text-gray-600">顧客名(カナ)</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ customer.name }} ({{ customer.kana }})
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="price" class="leading-7 text-sm text-gray-600">住所</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    〒{{ customer.postcode }}<br>
                                                    <span>{{ customer.address }}</span>
                                                    <span>{{ customer.affter_address }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="name" class="leading-7 text-sm text-gray-600">電話番号</label>
                                                <div
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ customer.tel }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-2 w-1/2">
                                            <label for="name" class="leading-7 text-sm text-gray-600">最終更新者:</label>
                                            <div
                                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ staff.name }}</div>
                                        </div>

                                        <div class="p-2 w-1/2">
                                            <label for="name" class="leading-7 text-sm text-gray-600">最終注文日:</label>
                                            <div v-if="props.lastOrderDay !== null"
                                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.lastOrderDay.time }}</div>
                                        </div>

                                        <div class="p-2 w-1/2">
                                            <label for="name" class="leading-7 text-sm text-gray-600">注文回数:</label>
                                            <div
                                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.orderCount }}回</div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="memo" class="leading-7 text-sm text-gray-600">備考欄</label>
                                                <div v-html="customer.remarks"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-center mt-5">
                                    <div class="p-2 w-1/10">
                                        <Link as="button" :href="route('customers.edit', { customer: customer.id})"
                                            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg mr-5">
                                        編集</Link>
                                    </div>

                                    <div class="p-2 w-1/10">
                                        <button @click.prevent="deleteCustomer(customer.id)"
                                            class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除</button>
                                    </div>
                                </div>
                                <div class="flex justify-center mt-5">
                                    <div class="p-2 w-full">
                                        <Link as="button" @click.prevent="pushReservation(1)"
                                            class="flex mx-auto text-white bg-yellow-500 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-600 rounded text-lg">
                                        予約画面へ送る</Link>
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