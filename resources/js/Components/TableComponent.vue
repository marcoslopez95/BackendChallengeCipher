<template>
    <div class="overflow-x-auto">

    <table class="w-full ">
        <thead>
            <tr class="border-b-2">
                <td
                    v-for="(head, index) in headers"
                    :key="index"
                    class="uppercase px-3 font-semibold text-center py-2"
                >
                    {{ head.title }}
                </td>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="(item, index) in items"
                :key="index"
                class="hover:bg-gray-100 border-b border-b-gray-200"
            >
                <td
                    v-for="(head, j) in headers"
                    :key="j"
                    class="text-center py-2"
                >
                    <div
                        v-if="head.value === 'actions'"
                        class="flex justify-center gap-3"
                    >
                        <i
                            v-if="!item.deleted_at"
                            title="Editar"
                            class="cursor-pointer"
                            @click="clickInEdit(item)"
                        >
                            <EditIcon />
                        </i>
                        <i
                            :title="!item.deleted_at ?'Eliminar' :'Restaurar'"
                            class="cursor-pointer"
                            @click="clickInDelete(item)"
                        >
                            <DeleteIcon
                                v-if="!item.deleted_at"
                            />
                            <RestoreIcon v-else/>
                        </i>
                        <slot name="newButtons" :item="item"> </slot>
                    </div>
                    <slot v-else :name="`cel-${head.value}`" :item="item">
                        {{ getValue(item, head) }}
                    </slot>
                </td>
            </tr>
        </tbody>
    </table>
</div>

    <Modal :show="showModal" @close="closeModal">
        <div>
            <div class="mt-4 mb-3 text-lg text-center font-bold uppercase">
                <div class="flex justify-center">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-14 h-14 text-red-500"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"
                        />
                    </svg>
                </div>
               {{ !item.deleted_at ? 'Eliminar' : 'Restaurar' }}
            </div>
            <div class="text-center text-lg">
                ¿Seguro de {{ !item.deleted_at ? 'eliminar' : 'restaurar' }} este registro?
            </div>
            <div class="my-4 flex justify-center gap-4">
                <primary-button
                    @click="confirmDelete"
                    class="bg-red-500 hover:bg-red-700 focus:bg-red-600 active:bg-red-600 focus:ring-red-500"
                >
                    Sí
                </primary-button>
                <SecondaryButton @click="closeModal"> No </SecondaryButton>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import { toRefs, ref } from "vue";
import EditIcon from "@/Icons/EditIcon.vue";
import RestoreIcon from "@/Icons/RestoreIcon.vue";
import DeleteIcon from "@/Icons/DeleteIcon.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
const props = defineProps({
    headers: {
        type: Array,
        default: () => [],
    },
    items: {
        type: Array,
        default: () => [],
    },
    withActions: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["clickInEdit", "clickInDelete"]);
const { headers } = toRefs(props);
const showModal = ref(false);

if (
    props.withActions &&
    !headers.value.find((item) => item.value === "actions")
) {
    headers.value.push({
        title: "Acción",
        value: "actions",
    });
}

const getValue = (item, head) => {
    const valueArray = head.value.split(".");
    let res = item;

    valueArray.forEach((pos) => {
        res = res[pos] ?? "";
    });

    if (typeof head == "string") {
        return res;
    }

    switch (head.type) {
        case "text":
            return res;
        default:
            return res;
    }
};

const item = ref('');
const clickInEdit = (item) => emits("clickInEdit", item);
const clickInDelete = (itemI) => {
    (showModal.value = true)
    item.value = itemI
};
const closeModal = () => (showModal.value = false);
const confirmDelete = () => {
    closeModal();
    emits("clickInDelete", item.value);
};
</script>

<style lang="scss" scoped></style>
