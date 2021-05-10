import axios from "axios";

const http = axios.create({
    baseURL: `${window.Laravel.baseUrl}/api`,
    headers: {
        common: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": window.Laravel.csrfToken
        }
    }
});

export default http;

export function uploadFile(file, setOpt) {
    const options = {
        url: "/uploads",
        ...setOpt
    };
    const formData = new FormData();
    formData.append("uploadFile", file);
    return http.post(options.url, formData);
}
