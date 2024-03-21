<script setup>
import { Head, Link } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import AlertComponent from '@/Components/AlertComponent.vue'

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
    title: {
        type: String,
        required: true,
    },
});

const page = usePage();

const shoppingCart = computed(() => page.props.shoppingCart);
const currencyPrincipal = computed(() => page.props.currencyPrincipal);

const notification = computed(() => page.props.notification);

</script>

<template>
    <AlertComponent  :type="notification?.type" :message="notification?.message ?? ''">
    </AlertComponent>
    <Head :title="title" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <header
                class="w-full max-w-2xl lg:max-w-7xl bg-gray-300/40 top-0 h-14 flex justify-end px-4"
            >
                <div class="shrink-0 flex items-center">
                    <Link :href="route('welcome')">
                        <ApplicationLogo
                            class="block h-9 w-auto fill-current text-gray-800"
                        />
                    </Link>
                </div>
                <nav
                    v-if="canLogin"
                    class="-mx-3 flex flex-1 justify-end my-auto"
                >
                    <div
                        class="hidden sm:flex sm:items-center sm:ms-6"
                        v-if="$page.props.auth.user"
                    >
                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="w-6 h-6"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"
                                                />
                                            </svg>
                                            <svg
                                                class="ms-2 -me-0.5 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <div class="mx-3">
                                        <div
                                            v-for="(
                                                item, index
                                            ) in ( shoppingCart.length > 4 ? shoppingCart.slice(0,4) : shoppingCart )"
                                            :key="index"
                                        >
                                            <div class="font-semibold">
                                                {{ item.product.name }}
                                            </div>
                                            <div class="text-right">
                                                Cantidad: {{ item.quantity }} -
                                                Subtotal:
                                                {{ currencyPrincipal.symbol }}
                                                {{
                                                    item.quantity *
                                                    item.product.price
                                                }}
                                            </div>
                                        </div>
                                        <div v-if="shoppingCart.length > 4">
                                            ver Todo
                                        </div>
                                        <div v-if="shoppingCart.length == 0">
                                            No has añadido productos
                                        </div>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                    <!-- <div v-if="$page.props.auth.user"> -->
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="rounded-md pr-1 pl-3 py-2 text-gray-500 ring-1 ring-transparent transition hover:text-gray-700 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Dashboard
                    </Link>
                    <div
                        class="hidden sm:flex sm:items-center sm:ms-6"
                        v-if="$page.props.auth.user"
                    >
                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center pr-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                        >
                                            {{ $page.props.auth.user.name }}

                                            <svg
                                                class="ms-2 -me-0.5 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                    >
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                    <!-- </div> -->

                    <template v-if="!$page.props.auth.user">
                        <Link
                            :href="route('login')"
                            class="rounded-md px-3 py-2 text-gray-500 ring-1 ring-transparent transition hover:text-gray-700 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Iniciar Sesión
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="rounded-md px-3 py-2 text-gray-500 ring-1 ring-transparent transition hover:text-gray-700 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Registro
                        </Link>
                    </template>
                </nav>
            </header>

            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <main class="mt-6">
                    <slot></slot>
                </main>

                <footer
                    class="py-16 text-center text-sm text-black dark:text-white/70"
                >
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template>
