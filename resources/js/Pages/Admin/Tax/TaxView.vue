<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TableComponent from '@/Components/TableComponent.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import {redirecTo} from '@/helper.js'
import axios from 'axios'

const props = defineProps({
    taxes: {
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
        title: 'Nombre',
        value: 'name'
    },
    {
        title: 'Tasa Fija',
        value: 'fixed'
    },
    {
        title: 'Tasa %',
        value: 'percentage'
    },
]

const edit = (tax) => {
    redirecTo(route('taxes.show',{ tax: tax.id }))
}

const create = () => redirecTo(route('taxes.create'))

const destroy = async(item) => {
    const url = route('taxes.destroy',{ tax: item.id })
    console.log(url)
    try{
        const response = await axios.delete(url)
        window.location.reload()
    }catch(e) {

    }

}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Impuestos
                </h2>
                <div>
                    <primary-button @click="create">
                        Crear
                    </primary-button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table-component
                        :headers="headers"
                        :items="taxes"
                        withActions
                        @clickInEdit="edit"
                        @clickInDelete="destroy"
                        >

                    </table-component>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
