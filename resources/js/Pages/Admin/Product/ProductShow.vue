<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { redirecTo } from "@/helper";
import { ref } from "vue";
import PrincipalLayout from '@/Layouts/PrincipalLayout.vue'

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    product: {
        type: Object,
        default: () => {},
    },
    currency: {
        type: Object,
        default: () => {},
    },
   
});

const addShoppingCard = () =>
    redirecTo(route("products.add-shopping-cart", { product: props.product.id }));

const showMore = ref(false);
</script>

<template>
    <PrincipalLayout
        :canLogin="canLogin"
        :canRegister="canRegister"
        :laravelVersion="laravelVersion"
        :phpVersion="phpVersion"
        title="Welcome"
    >
        <div class="grid gap-6 lg:grid-cols-4 lg:gap-8">
            <div class="lg:col-span-2 mx-auto">
                <img v-if="product.image" :src="product.image.url_temp" />
                <svg
                    v-else
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-32 h-32"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"
                    />
                </svg>
            </div>
            <div>
                <div class="text-4xl">
                    {{ product.name }}
                </div>
                <div class="text-2xl">
                    {{ currency.symbol }} {{ product.price }}
                </div>
                <div class="my-3">
                    <PrimaryButton @click="addShoppingCard"> Añadir </PrimaryButton>
                </div>
                <div
                    class="mt-5"
                    :class="{
                        'text-wrap h-40 truncate': !showMore,
                    }"
                >
                    {{ product.description }}
                </div>
                <div
                    class="mt-3 text-blue-500 cursor-pointer underline"
                    @click="showMore = !showMore"
                >
                    Mostrar {{ showMore ? "menos" : "más" }}
                </div>
            </div>
        </div>
    </PrincipalLayout>
</template>
