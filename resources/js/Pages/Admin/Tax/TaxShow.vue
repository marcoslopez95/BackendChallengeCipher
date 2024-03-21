<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm,router  } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { redirecTo } from "@/helper.js";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    tax: {
        type: Object,
        default: () => {},
    },
});

const form = useForm({
    name: props.tax?.name ?? '',
    fixed: props.tax?.fixed ?? '',
    percentage: props.tax?.percentage ?? '',
});

const back = () => {
    redirecTo(route("taxes.index"));
};

const submit =() =>{
    if(props.tax?.id){
        router.put(route('taxes.update',{
            tax: props.tax.id
        }), form)
    }else
    if(!props.tax?.id){
        router.post(route('taxes.store',), form)
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
                                    <InputLabel for="fixed" value="Tasa Fija" />

                                    <TextInput
                                        id="fixed"
                                        type="number"
                                        class="mt-1 block"
                                        v-model="form.fixed"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.fixed"
                                    />
                                </div>
                                <div>
                                    <InputLabel for="percentage" value="Tasa %" />

                                    <TextInput
                                        id="percentage"
                                        type="number"
                                        class="mt-1 block"
                                        v-model="form.percentage"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.percentage"
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
