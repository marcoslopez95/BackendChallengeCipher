<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TableComponent from '../../Components/TableComponent.vue';

const props = defineProps({
    currencies: {
        type: Array,
        default: () => []
    }
})

const headers = [
    {
        title: 'id',
        value: 'id'
    },
    {
        title: 'nombre',
        value: 'name'
    },
    {
        title: 'abreviación',
        value: 'abbreviation'
    },
    {
        title: 'símbolo',
        value: 'symbol'
    },
    {
        title: 'Tasa Cambio',
        value: 'exchange'
    },
    {
        title: 'Principal',
        value: 'principal'
    },
]
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Monedas</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table-component
                        :headers="headers"
                        :items="currencies"
                        withActions
                        >
                        <template #cel-principal="{ item }">
                            <div class="w-full flex justify-center " >
                                <div class="w-10 rounded-lg mx-center"
                                    :class="[
                                        item.principal ? 'bg-green-400' : 'bg-red-400'
                                    ]">
                                    {{ item.principal ? 'Sí' : 'No' }}
                                </div>
                            </div>
                        </template>
                    </table-component>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
