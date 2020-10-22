import axios from "axios";

const axiosInstance = axios.create({
    baseURL: `${APP_URL}api/`
    /* other custom settings */
});

export default axiosInstance;
