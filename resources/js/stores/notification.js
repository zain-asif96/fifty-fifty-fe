import {defineStore} from 'pinia'

export const useNotificationStore = defineStore('notification', {
    state: () => {
        return {
            isShown: false,
            type: '',
            message: ''
        }
    },
    actions: {
        notify(message, type) {
            this.isShown = true;
            this.type = type;
            this.message = message;

            setTimeout(() => {
                this.isShown = false;
            }, 5000)
        }
    }
})
