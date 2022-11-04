<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import { Core as YubinBangoCore } from "yubinbango-core2";
import { useField, useForm } from "vee-validate";
import { object, string, number } from 'yup';

const props = defineProps({
    customer: Object
})

const form = reactive({
    address: props.customer.address,
})

const fetchAddress = (p) => {
    new YubinBangoCore(String(p), (value) => {
        form.address = value.region + value.locality + value.street
    })
}

const schema = object({
    name: string().required('名前は必須です').max(20, '20文字以下を入れてください').label('名前'),
    kana: string().required('カナは必須です').max(20, '20文字以下を入れてください').label('カナ'),
    tel: number().typeError("数字のみ入力してください").required("電話番号は必須です").min(99999999, "数字9文字以上で入力してください").max(9999999999, "数字11文字以下で入力してください").label('電話番号'),
    postcode: string().required('郵便番号は必須です').matches(/^[0-9]{7}$/, '数字7文字で入力してください').label('郵便番号'),
    affter_address: string().required('番地・　住所は必須です').label('番地・　住所'),
    remarks: string().max(255, '255文字以下を入れてください').label('備考欄'),
});

const { errors, meta, handleChange, handleSubmit, isSubmitting } = useForm({
    validationSchema: schema,
    initialValues: {
        name: props.customer.name,
        kana: props.customer.kana,
        tel: props.customer.tel,
        remarks: props.customer.remarks ?? '',
        postcode: props.customer.postcode,
        affter_address: props.customer.affter_address,
        address: props.customer.address
    },
});

const { value: name } = useField("name");
const { value: tel } = useField('tel');
const { value: kana } = useField("kana");
const { value: postcode } = useField('postcode');
const { value: affter_address } = useField("affter_address");
const { value: remarks } = useField('remarks');

const udpateCustomer = handleSubmit((values, id) => {
    values.address = form.address
    if (confirm('この内容で登録でよろしいでしょうか？')) {
        Inertia.put(route('customers.update', { customer: id.evt }), values)
    }
});
</script>

<template>

    <Head title="顧客編集" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight bgblue-300">
                顧客編集
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
                                    <input type="text" id="name" name="name" v-model="name" @blur="handleChange"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    <p style="color: red;">{{ errors.name }}</p>
                                </div>
                            </div>

                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="kana" class="leading-7 text-sm text-gray-600">カナ</label>
                                    <input type="text" id="kana" name="kana" v-model="kana"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    <p style="color: red;">{{ errors.kana }}</p>
                                </div>
                            </div>

                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                                    <input type="text" id="tel" name="tel" v-model="tel" @blur="handleChange"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <p style="color: red;">{{ errors.tel }}</p>
                                </div>
                            </div>

                            <div class="p-2  w-1/2">
                                <div class="relative">
                                    <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label><br>
                                    <input type="text" id="postcode" name="postcode" v-model="postcode"
                                        @change="fetchAddress(postcode)"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <p style="color: red;">{{ errors.postcode }}</p>
                                </div>
                            </div>

                            <div class="p-2  w-full">
                                <div class="relative">
                                    <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                    <input type="text" id="address" name="address" v-model="form.address" readonly
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>

                            <div class="p-2  w-full">
                                <div class="relative">
                                    <label for="address" class="leading-7 text-sm text-gray-600">番地・建物名</label>
                                    <input type="text" id="address" name="address" v-model="affter_address"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <p style="color: red;">{{ errors.affter_address }}</p>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="remarks" class="leading-7 text-sm text-gray-600">備考欄</label>
                                    <textarea id="remarks" name="remarks" v-model="remarks"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                    <p style="color: red;">{{ errors.remarks }}</p>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <button :disabled="!meta.valid | isSubmitting" v-if="meta.valid"
                                    class="validate-color flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                                <button :disabled="!meta.valid" v-else
                                    class="validate-color flex mx-auto text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none rounded text-lg">登録</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </AuthenticatedLayout>
</template>