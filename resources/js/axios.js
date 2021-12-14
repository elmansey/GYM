import axios from "axios";
import { store } from "./store";

axios.defaults.baseURL = `${process.env.MIX_RUN_URL}/api/`;

axios.defaults.headers.common = {
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    "X-Requested-With": "XMLHttpRequest"
};

axios.interceptors.request.use(request => {
    if (store.getters.AUTH_TOKEN) {
        request.headers.common[
            "Authorization"
        ] = `Bearer ${store.getters.AUTH_TOKEN}`;
    }
    return request;
});
