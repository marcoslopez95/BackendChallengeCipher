<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    id: {
        type: String,
    },
    title: {
        type: String,
    },
    price: {
        type: String,
    },
    tax: {
        type: String,
    },
    description: {
        type: String,
    },
});

const form = useForm({
    title: props.title,
    price: props.price,
    tax: props.tax,
    description: props.description,
});

const submit = () => {
    form.patch(route('products.update', {product:props.id}), {
        onFinish: () => form.reset(
            'title',
            'price',
            'tax',
        ),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Edit" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Product</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="title" value="Title" />
                            <TextInput
                                id="title"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.title"
                                required
                                autofocus
                                autocomplete="Product title"
                            />
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>
                        <div class="mt-4 grid grid-cols-2">
                            <div class="mt-4">
                                <InputLabel for="price" value="Price" />
                                <TextInput
                                    id="price"
                                    type="text"
                                    class="mt-1"
                                    v-model="form.price"
                                    required
                                    autocomplete="$0.00"
                                />
                                <InputError class="mt-2" :message="form.errors.price" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="tax" value="Tax" />
                                <TextInput
                                    id="tax"
                                    type="text"
                                    class="mt-1"
                                    v-model="form.tax"
                                    required
                                    autocomplete="$0.00"
                                />
                                <InputError class="mt-2" :message="form.errors.tax" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <InputLabel for="description" value="Description" />
                            <Textarea
                                id="description"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.description"
                                required
                                autocomplete="Product title"
                            />
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="file" value="imagen" />
                            <TextInput
                                id="file"
                                type="file"
                                class="mt-1"
                                v-model="form.imagen"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.file" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                create product
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
