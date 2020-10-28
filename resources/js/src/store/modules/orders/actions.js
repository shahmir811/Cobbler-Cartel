import axios from "../../BaseUrl";

export const getAllOrders = async ({ state, commit, rootState, dispatch }) => {
    commit("setLoading", true);
    try {
        const response = await axios.get("/admin/orders");
        commit("setOrders", response.data.data.orders);
        commit("filterMyOrders");
        commit("getNoFilterRecord");

        commit("setLoading", false);
    } catch (error) {
        console.log(error);

        commit("setLoading", false);
    }
};

export const getOrderByStatus = ({ state, commit }, status) => {
    commit("filterMyOrders", status);
};

export const getOrderByOrderNo = ({ state, commit }, orderNo) => {
    commit("getSpecificRecords", orderNo);
};

export const noFilterRecord = ({ state, commit }) => {
    commit("getNoFilterRecord");
};

export const removeOrder = async (
    { state, commit, rootState, dispatch },
    id
) => {
    try {
        await axios.delete(`/admin/orders/${id}`);

        dispatch(
            "flashMessage",
            {
                message: "Order deleted successfully",
                type: "success"
            },
            { root: true }
        );

        commit("removeOrderFromOrdersList", id);
    } catch (error) {
        console.log(error);
    }
};
