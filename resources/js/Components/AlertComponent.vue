<template>
    <div class="fixed top- right-0 z-10">

    <transition name="fade">
        <div
            v-if="show"
            class="max-w-xs border text-sm rounded-lg"
            :class="getColor"
        >
            <div class="flex p-4">
                <slot>
                    {{message}}
                </slot>
                <div class="ml-auto">
                    <button
                        type="button"
                        @click="close"
                        class="inline-flex flex-shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 dark:text-white"
                    >
                        <span class="sr-only">Close</span>
                        <svg
                            class="flex-shrink-0 size-4"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </transition>
    </div>
</template>

<script setup>
import { ref,computed, watch } from "vue";

const { type,message } = defineProps({
    type: {
        type: String,
        default: "default",
        validator(value) {
            return [
                "default",
                "info",
                "success",
                "primary",
                "error",
                "warning",
            ].includes(value);
        },
    },
    message: {
        type: String,
        default: ''
    }
});

const show = ref(!!message);

// watch(message,() => message ? show.value = true: '')


const close = () => {
    show.value = false;
};

const colors = ref({
    success :'teal',
    info :'blue',
    error :'red',
    warning :'yellow',
    default: 'gray'
});

const getColor = computed( () => {
    return `bg-${colors.value[type]}-300 border-${colors.value[type]}-400 text-${colors.value[type]}-800`

})

const timeout = setTimeout(() => {
    close()

},5000)

</script>

<style scoped>


.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease-in-out;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
