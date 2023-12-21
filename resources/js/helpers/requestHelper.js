import axios from "axios";
import { userUserStore } from "@/stores/user";
export const BASE_URL = "https://appiosandbackend-production.up.railway.app";
export const request = async ({
    BASE_URL = "https://appiosandbackend-production.up.railway.app/",
    type = "get",
    payload = {},
    url = "",
    params = "",
    query = "",
}) => {
    const $userStore = userUserStore();
    let Url = `${BASE_URL}${url}`;
    if (params) {
        Url = `${Url}/` + params;
    }
    if (query) {
        Url = `${Url}?` + query;
    }
    let token = $userStore.getUserApp
        ? $userStore.getUserApp?.data?.auth_token
        : "";

    try {
        let resp;
        if (type === "get") {
            resp = await axios.get(Url, {
                headers: { Authorization: `Bearer ${token}` },
            });
        } else if (type === "post") {
            resp = await axios.post(Url, payload, {
                headers: { Authorization: `Bearer ${token}` },
            });
        } else if (type === "patch") {
            resp = await axios.patch(Url, payload, {
                headers: { Authorization: `Bearer ${token}` },
            });
        } else if (type === "put") {
            resp = await axios.put(Url, payload, {
                headers: { Authorization: `Bearer ${token}` },
            });
        } else if (type === "delete") {
            resp = await axios.delete(Url, {
                headers: { Authorization: `Bearer ${token}` },
            });
        }
        return resp;
    } catch (error) {
        return error;
    }
};
