<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/inertia-vue3';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import { useField, useForm } from "vee-validate";
import { object, string } from 'yup';

const props = defineProps({
    item: Object,
    state: Array
})

const schema = object({
    name: string().required('名前は必須です').max(20, '20文字以内で入力してください').label('名前'),
    price: string().required('金額は必須です').max(4, '4桁以内で入力してください').label('金額'),
    allergy: string().required('アレルギーは必須です').max(255, '255文字以下を入れてください').label('アレルギー'),
    introduction: string().required('説明は必須です').max(255, '255文字以下を入れてください').label('説明'),
});

const { errors, meta, handleChange, handleSubmit, isSubmitting } = useForm({
    validationSchema: schema,
    initialValues: {
        name: props.item.name,
        price: props.item.price,
        status: props.item.status,
        allergy: props.item.allergy,
        introduction: props.item.introduction,
    },
});

const { value: name } = useField("name");
const { value: price } = useField('price');
const { value: status } = useField("status");
const { value: allergy } = useField('allergy');
const { value: introduction } = useField("introduction");

const updateItem = handleSubmit((values, id) => {
    if (confirm('この内容で登録でよろしいでしょうか？')) {
        Inertia.put(route('items.update', { item: id.evt }), values)
    }
})
</script>

<template>

    <Head title="商品編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight bgblue-300">
                商品編集
            </h2>
        </template>

        <section class="text-gray-600 body-font relative">
            <ValidationErrors class="mb-4" />
            <form @submit.prevent="updateItem(item.id)">
                <div class="container px-5 py-8 mx-auto">
                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">名前</label>
                                    <input type="text" id="name" name="name" v-model="name"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <p style="color: red;">{{ errors.name }}</p>
                                </div>
                            </div>

                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="price" class="leading-7 text-sm text-gray-600">金額</label>
                                    <input type="number" id="price" name="price" v-model="price"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <p style="color: red;">{{ errors.price }}</p>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="allergy" class="leading-7 text-sm text-gray-600">アレルギー表</label>
                                    <textarea id="allergy" name="allergy" v-model="allergy"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                    <p style="color: red;">{{ errors.allergy}}</p>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="remarks" class="leading-7 text-sm text-gray-600">メニュー紹介</label>
                                    <textarea id="remarks" name="remarks" v-model="introduction"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                    <p style="color: red;">{{ errors.introduction }}</p>
                                </div>
                            </div>


                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="tel" class="leading-7 text-sm text-gray-600">ステータス</label><br>
                                    <span class="ml-2" v-for="s in state">
                                        {{ s }}
                                        <input type="radio" id="status" name="status" v-model="status" class="ml-2"
                                            :value="s" />
                                    </span>
                                    <p style="color: red;">{{ errors.status }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 w-full">
                            <button :disabled="!meta.valid || isSubmitting" v-if="meta.valid"
                                class="validate-color flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                            <button :disabled="!meta.valid || isSubmitting" v-else
                                class="validate-color flex mx-auto text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none rounded text-lg">登録</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>

    </AuthenticatedLayout>
</template>