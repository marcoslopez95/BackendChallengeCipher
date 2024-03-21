<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm,router  } from "@inertiajs/vue3";
import TableComponent from "../../Components/TableComponent.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { redirecTo } from "@/helper.js";
import { reactive } from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { ref } from "vue";

const props = defineProps({
    currency: {
        type: Object,
        default: () => {},
    },
});

const form = useForm({
    name: props.currency?.name ?? '',
    symbol: props.currency?.symbol ?? '',
    principal: !!props.currency?.principal ?? false,
    abbreviation: props.currency?.abbreviation ?? '',
    exchange: props.currency?.exchange?.toString() ?? '',
});

const back = () => {
    redirecTo(route("currencies.index"));
};

const submit =() =>{
    if(props.currency?.id){
        router.put(route('currencies.update',{
            currency: props.currency.id
        }), form)
    }else
    if(!props.currency?.id){
        router.post(route('currencies.store',), form)
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Monedas
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
                                        :message="form.errors.name"
                                    />
                                </div>
                                <div class="">
                                    <InputLabel for="abbreviation" value="Abreviación" />

                                    <TextInput
                                        id="abbreviation"
                                        type="text"
                                        class="mt-1 block"
                                        v-model="form.abbreviation"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.abbreviation"
                                    />
                                </div>
                                <div>
                                    <InputLabel for="symbol" value="Símbolo" />

                                    <TextInput
                                        id="symbol"
                                        type="text"
                                        class="mt-1 block"
                                        v-model="form.symbol"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.name"
                                    />
                                </div>
                                <div>
                                    <InputLabel for="exchange" value="Tasa Cambio" />

                                    <TextInput
                                        id="exchange"
                                        type="number"
                                        class="mt-1 block"
                                        v-model="form.exchange"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.exchange"
                                    />
                                </div>
                                <div>
                                    <InputLabel for="principal" value="Principal" />

                                    <Checkbox
                                        id="principal"
                                        :checked="form.principal"
                                        @update:checked="(v)=>form.principal = v"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.exchange"
                                    />
                                </div>
                                <div class="col-span-3 text-right">
                                    <primary-button>
                                        Guardar
                                    </primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
