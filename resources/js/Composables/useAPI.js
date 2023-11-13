import {reactive, ref} from "vue";

export function useAPI() {
    const isLoading = ref(false);
    const errors = reactive({});

    const handleErrors = (err) => {
        if (err.response?.status === 422) errors.value = err.response.data.errors;
        else if (err.response?.status === 419) handleSessionExpired();
        else errors.value = err;
    }

    const startRequest = () => {
        isLoading.value = true;
        errors.value = {};
    }

    const requestCompleted = () => {
        isLoading.value = false;
    }

    const handleSessionExpired = () => {
        window.location = window.location.href;
    }

    return {
        handleErrors,
        requestCompleted,
        startRequest,
        isLoading,
        errors
    }
}
