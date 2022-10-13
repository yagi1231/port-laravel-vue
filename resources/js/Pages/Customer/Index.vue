<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Components/Pagination.vue';
import { onMounted, reactive, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import FlashMessage from '@/Components/FlashMessage.vue';

defineProps({
    customers: Object
})

const serach = reactive({
    inputingName: null,
    inputingTel: null,
    inputingAddress: null
})

const serachCustomer = () => {
    Inertia.get('customers', serach)
}

const inputingForm = ref(false)

const openForm = () => {
    inputingForm.value = !inputingForm.value
}
</script>

<template>

    <Head title="顧客一覧表" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                顧客一覧表
            </h2>
        </template>

        <FlashMessage />

        <form @submit.prevent="serachCustomer">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <button @click.prevent="openForm"
                        class="flex text-black border-0 py-2 px-6 focus:outline-none rounded w-1/6 justify-center bg-white">検索フォーム</button>
                    <div v-if="!inputingForm" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex justify-center">
                                <div class="p-2 w-1/6">
                                    <label>名前:</label><br>
                                    <input type="text"
                                        class="ml-3 w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300"
                                        name="name" v-model="serach.inputingName">
                                </div>

                                <div class="p-2 w-1/6">
                                    <label>電話番号:</label><br>
                                    <input type="text"
                                        class="ml-3 w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300"
                                        name="tel" v-model="serach.inputingTel">
                                </div>

                                <div class="p-2 w-1/3">
                                    <label>住所:</label><br>
                                    <input type="text"
                                        class="ml-3 w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300"
                                        name="address" v-model="serach.inputingAddress">
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
            </div>
        </form>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-12 mx-auto">
                                <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                                    <Link as="button" :href="route('customers.create')"
                                        class="flex ml-auto text-black bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded mb-3">
                                    新規登録</Link>
                                </div>
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                    名前</th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    住所</th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    電話番号</th>
                                                <th
                                                    class="w-20 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                                    前回注文日</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="customer in customers.data" :key="customer.id">
                                                <td class="px-4 py-3">
                                                    <Link class="text-blue-400"
                                                        :href="route('customers.show', { customer: customer.id })">
                                                    {{ customer.name }}
                                                    </Link>
                                                </td>
                                                <td class="px-4 py-3">{{ customer.address }}</td>
                                                <td class="px-4 py-3">{{ customer.tel }}</td>
                                                <td class="px-4 py-3">{{ customer.name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                        <Pagination class="m-6 flex justify-center" :links="customers.links"></Pagination>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
