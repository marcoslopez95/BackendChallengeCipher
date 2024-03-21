<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { redirecTo } from "@/helper";
import PrincipalLayout from '@/Layouts/PrincipalLayout.vue'

defineProps({
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
    products: {
        type: Array,
        default: () => [],
    },
    currency: {
        type: Object,
        default: () => {},
    },
});

const goProduct = (product) => redirecTo(route('products.show',{ product: product.id }))
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
            <div
                v-for="(product, index) in products"
                :key="index"
                class="cursor-pointer flex flex-col items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                @click="goProduct(product)"
            >
                <div class="mx-auto">
                    <img
                        v-if="product.image"
                        :src="product.image.url_temp"
                    />
                    <svg
                        v-else
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-10 h-10"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"
                        />
                    </svg>
                </div>
                <div class="text-2xl font-bold w-full truncate ">
                    {{ product.name }}
                </div>
                <div class="text-xl text-center w-full">
                    {{ currency.symbol }} {{ product.price }}
                </div>
            </div>
        </div>
    </PrincipalLayout>
</template>
