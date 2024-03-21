<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import TableComponent from "@/Components/TableComponent.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { redirecTo } from "@/helper.js";
import axios from "axios";

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
});

const headers = [
    {
        title: "id",
        value: "id",
    },
    {
        title: "nombre",
        value: "name",
    },
    {
        title: "Costo",
        value: "cost",
    },
    {
        title: "Precio Venta",
        value: "price",
    },
];

const edit = (product) => {
    redirecTo(route("products.show", { product: product.id }));
};

const create = () => redirecTo(route("products.create"));

const destroy = async (item) => {
    const url = route("products.destroy", { product: item.id });
    console.log(url);
    try {
        const response = await axios.delete(url);
        window.location.reload();
    } catch (e) {}
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
                    <primary-button @click="create"> Crear </primary-button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table-component
                        :headers="headers"
                        :items="products"
                        withActions
                        @clickInEdit="edit"
                        @clickInDelete="destroy"
                    >
                        <template #cel-principal="{ item }">
                            <div class="w-full flex justify-center">
                                <div
                                    class="w-10 rounded-lg mx-center"
                                    :class="[
                                        item.principal
                                            ? 'bg-green-400'
                                            : 'bg-red-400',
                                    ]"
                                >
                                    {{ item.principal ? "Sí" : "No" }}
                                </div>
                            </div>
                        </template>
                    </table-component>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
