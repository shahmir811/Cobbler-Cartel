import { isEmpty } from "lodash";
import axios from "../store/BaseUrl";

export const setHttpToken = token => {
    if (isEmpty(token)) {
        axios.defaults.headers.common["Authorization"] = null;
        return;
    }

    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
};
