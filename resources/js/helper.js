import { ref } from 'vue'

export const redirecTo = (route_name) => window.location.href = route_name

export const alertStore = () => {

    const show = ref(false)
    const type = ref('default')
    const message = ref('')

    const showNotify = ( msg, tp ) => {
        message.value = msg
        type.value = tp
        show.value = true
    }

    return {
        show,
        type,
        message,
        showNotify
    }
}
