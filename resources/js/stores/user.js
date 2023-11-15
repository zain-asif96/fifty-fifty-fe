// store.js
import { defineStore } from "pinia";

export const userUserStore = defineStore("user", {
    state: () => ({
        user: {},
    }),
    actions: {
        setUserApp(user) {
            this.user = user;
            localStorage.setItem("app_admin", JSON.stringify(user));
        },
        logoutAppAdmin() {
            this.user = {};

            localStorage.removeItem("app_admin");
        },
    },
    getters: {
        getUserApp() {
            let user = localStorage.getItem("app_admin");
            let adminUser = JSON.parse(user);
            return adminUser;
        },
    },
});
