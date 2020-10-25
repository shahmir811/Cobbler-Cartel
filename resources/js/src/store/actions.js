import axios from "./BaseUrl";
import router from "../routes/router";

export const flashMessage = ({ commit }, alert) => {
    commit("setMessage", alert);

    setTimeout(() => {
        commit("clearMessage");
    }, 3000);
};

/////////////////////// UploadExcel File ///////////////////////
export const uploadExcelFile = async (
    { state, commit, rootState, dispatch },
    formData
) => {
    commit("setLoading", true);
    commit("clearErrors");

    try {
        const response = await axios.post("/admin/upload-file", formData);

        commit("setLoading", false);

        dispatch("flashMessage", {
            message: "Records uploaded successfully",
            type: "success"
        });

        router.push({ name: "admin-orders" });
        commit("setLoading", false);
    } catch (error) {
        console.log(error);
        commit("setError", error.response.data.errors);
        commit("setLoading", false);
    }
};
