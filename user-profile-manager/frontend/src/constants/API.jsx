import axios from "axios";

export const BASE_URL = "http://localhost/phpcodes/user-profile-manager/backend/api";

export const API = axios.create({
    baseURL: BASE_URL,
    withCredentials: true,
    headers: {
        "Content-Type":"application/json",
    }
});