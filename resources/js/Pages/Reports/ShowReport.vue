<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    id: {
        type: String,
    },
    title: {
        type: String,
    },
    begin_date: {
        type: String,
    },
    end_date: {
        type: String,
    },
    user: {
        type: String,
    },
    shoppings: {
        type: [Array],
    },
    total_revenue: {
        type: String,
    },
    total_cost: {
        type: String,
    },
    total_tax: {
        type: String,
    },
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Report" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Report N° {{ id }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <div class="mt-4">{{title}}</div>
                    <div class="mt-4">{{begin_date}}</div>
                    <div class="mt-4">{{end_date}}</div>
                    <div class="mt-4">{{user}}</div>
                    <div class="mt-4">{{total_revenue}}</div>
                    <div class="mt-4">{{total_cost}}</div>
                    <div class="mt-4">{{total_tax}}</div>
                    <div class="position-relative">
                        <table class="border-collapse border border-slate-500 w-full">
                            <thead>
                                <tr>
                                    <th class="border border-slate-600">date</th>
                                    <th class="border border-slate-600">user name</th>
                                    <th class="border border-slate-600">items</th>
                                    <th class="border border-slate-600">pay amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="shopping in shoppings">
                                    <tr>
                                        <td class="border border-slate-700">{{shopping.date}}</td>
                                        <td class="border border-slate-700">{{shopping.user}}</td>
                                        <td class="border border-slate-700">{{shopping.items}}</td>
                                        <td class="border border-slate-700">{{shopping.total}}</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
