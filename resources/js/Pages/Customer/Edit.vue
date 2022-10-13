<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import ValidationErrors from '@/Components/ValidationErrors.vue';

const props = defineProps({
    customer: Object
})

const form = reactive({
    name: props.customer.name,
    kana: props.customer.kana,
    address: props.customer.address,
    tel: props.customer.tel,
    remarks: props.customer.remarks,
    postcode: props.customer.postcode,
})

const udpateCustomer = (id) => {
    if (confirm('この内容で登録でよろしいでしょうか？')) {
        Inertia.put(route('customers.update', { customer: id }), form)
    }
}

const fetchAddress = () => {
    new YubinBangoCore(String(form.postcode), (value) => {
        console.log(value)
        form.address = value.region + value.locality + value.street
    })
}
</script>

<template>

    <Head title="顧客登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight bgblue-300">
                顧客登録
            </h2>
        </template>

        <section class="text-gray-600 body-font relative">
            <ValidationErrors class="mb-4" />
            <form @submit.prevent="udpateCustomer(customer.id)">
                <div class="container px-5 py-8 mx-auto">
                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">名前</label>
                                    <input type="text" id="name" name="name" v-model="form.name"
                                        @input="handleNameInput"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <!-- <span v-if="!formValidate"
                                        class="list-disc list-inside text-sm text-red-600">20文字以内で入力して下さい</span> -->
                                </div>
                            </div>

                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="kana" class="leading-7 text-sm text-gray-600">カナ</label>
                                    <input type="text" id="kana" name="kana" v-model="form.kana"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>

                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                                    <input type="text" id="tel" name="tel" v-model="form.tel"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>

                            <div class="p-2  w-1/2">
                                <div class="relative">
                                    <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label><br>
                                    <input type="text" id="postcode" name="postcode" v-model="form.postcode"
                                        @change="fetchAddress"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>

                            <div class="p-2  w-full">
                                <div class="relative">
                                    <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                    <input type="text" id="address" name="address" v-model="form.address"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="remarks" class="leading-7 text-sm text-gray-600">備考欄</label>
                                    <textarea id="remarks" name="remarks" v-model="form.remarks"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <button
                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>

    </AuthenticatedLayout>
</template>