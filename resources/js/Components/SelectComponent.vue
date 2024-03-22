<template>
    <div class="w-full md:w-1/2 flex flex-col items-center h-64 mx-auto">
        <div class="w-full px-4">
            <div class="flex flex-col items-center relative">
                <div class="w-full svelte-1l8159u">
                    <div
                        class="my-2 p-1 flex border border-gray-200 bg-white rounded svelte-1l8159u"
                    >
                        <div class="flex flex-auto flex-wrap">
                            <div class="flex-1">
                                <input
                                    class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800 min-w-80 max-w-150 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block font-medium text-sm text-gray-700"
                                />
                            </div>
                            <div
                                v-for="item in selectedItems"
                                :key="item.id"
                                class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-teal-700 bg-teal-100 border border-teal-300"
                            >
                                <div
                                    class="text-xs font-normal leading-none max-w-full flex-initial"
                                >
                                    {{ item[label] }}
                                </div>
                                <div class="flex flex-auto flex-row-reverse">
                                    <div @click="removeSelectedItem(item)">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="100%"
                                            height="100%"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-x cursor-pointer hover:text-teal-400 rounded-full w-4 h-4 ml-2"
                                        >
                                            <line
                                                x1="18"
                                                y1="6"
                                                x2="6"
                                                y2="18"
                                            ></line>
                                            <line
                                                x1="6"
                                                y1="6"
                                                x2="18"
                                                y2="18"
                                            ></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button
                            @click.prevent="toggleShowOptions"
                            class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none"
                        >
                            <svg
                                v-if="showOptions"
                                xmlns="http://www.w3.org/2000/svg"
                                width="100%"
                                height="100%"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-chevron-up w-4 h-4"
                            >
                                <polyline points="18 15 12 9 6 15"></polyline>
                            </svg>
                            <svg
                                v-else
                                xmlns="http://www.w3.org/2000/svg"
                                width="100%"
                                height="100%"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-chevron-down w-4 h-4"
                            >
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div
                            v-if="showOptions"
                            class="menu-dropdown absolute shadow top-100 bg-white z-40 w-full left-0 rounded max-h-select overflow-y-auto svelte-5uyqqj"
                        >
                            <div class="flex flex-col w-full">
                                <div
                                    v-for="item in items"
                                    :key="item.id"
                                    class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100"
                                    @click="toggleSelection(item)"
                                >
                                    <div
                                        class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100"
                                    >
                                        <div class="w-auto items-center flex">
                                            <div class="mx-2 leading-6">{{ item[label] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';

const props = defineProps({
  items: {
    type: Array,
    required: true
  },
  label: {
    type: String,
    default: 'name'
  }
});

const emits = defineEmits(['update:items']);

const showOptions = ref(false);
const selectedItems = ref([]);

const toggleSelection = (item) => {
  if (!isSelected(item)) {
    selectedItems.value.push(item);
    emits('update:items', selectedItems.value);
    removeItem(item);
  }
};

const removeSelectedItem = (item) => {
  selectedItems.value = selectedItems.value.filter(selectedItem => selectedItem !== item);
  emits('update:items', selectedItems.value);
  if (!props.items.includes(item)) {
    props.items.push(item);
  }
};

const isSelected = (item) => {
  return selectedItems.value.some(selectedItem => selectedItem === item);
};

const removeItem = (item) => {
  const index = props.items.findIndex(i => i === item);
  if (index !== -1) {
    props.items.splice(index, 1);
  }
};

const toggleShowOptions = () => {
  showOptions.value = !showOptions.value;
};
</script>

<!-- Estilos -->

<style scoped>
.top-100 {
    top: 100%;
}
.bottom-100 {
    bottom: 100%;
}
.max-h-select {
    max-height: 300px;
}
</style>
