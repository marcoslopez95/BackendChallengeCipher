<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { redirecTo } from "@/helper.js";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    product: {
        type: Object,
        default: () => {},
    },
    errors: Object
});

const form = useForm({
    name: props.product?.name ?? "",
    cost: props.product?.cost ?? "",
    price: props.product?.price ?? '',
});

const back = () => {
    redirecTo(route("products.index"));
};

const submit = () => {
    if (!props.product?.id) {
        router.post(route("products.store"), form);
        return;
    }
    router.put(
        route("products.update", {
            product: props.product.id,
        }),
        form
    );
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Productos
                </h2>
                <div>
                    <SecondaryButton @click="back"> Atrás </SecondaryButton>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="mx-3 my-4">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="">
                                    <InputLabel
                                        class="w-2/3"
                                        for="name"
                                        value="Nombre"
                                    />

                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-2/3"
                                        v-model="form.name"
                                        required
                                        autofocus
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="errors.name"
                                    />
                                </div>
                                <div class="">
                                    <InputLabel
                                        for="cost"
                                        value="Precio Costo"
                                    />

                                    <TextInput
                                        id="cost"
                                        type="number"
                                        class="mt-1 block"
                                        v-model="form.cost"
                                        step="0.01"
                                        min="0"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="errors.cost"
                                    />
                                </div>
                                <div>
                                    <InputLabel
                                        for="price"
                                        value="Precio Venta"
                                    />

                                    <TextInput
                                        id="price"
                                        type="number"
                                        class="mt-1 block"
                                        v-model="form.price"
                                        required
                                        step="0.01"
                                        min="0"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="errors.price"
                                    />
                                </div>
                                <div class="col-span-3 text-right">
                                    <primary-button> Guardar </primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
