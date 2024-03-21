<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { redirecTo } from "@/helper.js";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PhotoIcon from '@/Icons/PhotoIcon.vue'
import { ref } from 'vue'
import SelectComponent from '@/Components/SelectComponent.vue'

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
    image: ''
});

const urlImage = ref(props.product?.image?.url_temp ??'')

const back = () => {
    redirecTo(route("products.index"));
};

const submit = () => {
    if (!props.product?.id) {
        router.post(route("products.store"), form,{
            forceFormData: true
        });
        return;
    }
    router.post(
        route("products.update", {
            product: props.product.id,
        }),
        {
            _method: 'put',
            ...form
        }
    );
};

const uploadFile = (e) => {

    const files = e.target.files
    if(files.length == 0) return

    urlImage.value = URL.createObjectURL(files[0])
    form.image = files[0]
}
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
                                <div class="col-span-3 flex">
                                    <SelectComponent />
                                </div>
                                <div class="col-span-2 flex">
                                    <div class="mx-auto">
                                        <InputLabel
                                            for="image"
                                            value="Imagen"
                                            class="text-center"
                                        />
                                        <label for="image">
                                            <i v-if="!urlImage">
                                                <PhotoIcon class="w-32 h-32  mx-auto"/>
                                            </i>
                                            <img
                                                v-else
                                                :src="urlImage"
                                                class="w-32 h-32 mx-auto"
                                                />
                                        </label>

                                        <input
                                            id="image"
                                            type="file"
                                            class="hidden"
                                            @change="uploadFile"

                                        />

                                        <InputError
                                            class="mt-2"
                                            :message="errors.image"
                                        />
                                    </div>
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
