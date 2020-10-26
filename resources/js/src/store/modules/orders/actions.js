import axios from "../../BaseUrl";

export const getAllOrders = async ({ state, commit, rootState, dispatch }) => {
    commit("setLoading", true);
    try {
        const response = await axios.get("/admin/orders");
        commit("setOrders", response.data.data.orders);
        commit("filterMyOrders");

        commit("setLoading", false);
    } catch (error) {
        console.log(error);

        commit("setLoading", false);
    }
};

export const getOrderByStatus = ({ state, commit }, status) => {
    commit("filterMyOrders", status);
};
