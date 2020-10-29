import axios from "../../BaseUrl";
import router from "../../../routes/router";

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

export const getOrderDetails = ({ state, commit }, id) => {
    commit("viewOrderNo", id);
};

export const clearOrdersState = ({ state, commit }) => {
    commit("resetOrdersState");
};

/////////////////////// Complete Order ///////////////////////
export const completeOrder = async ({ state, commit, rootState }, id) => {
    const { role } = rootState.auth.user;

    try {
        await axios.get(`/${role}/complete-order/${id}`);

        commit("removeCompleteOrder", id);
    } catch (error) {
        console.log(error);
    }
};

/////////////////////// select Order to change Status ///////////////////////
export const selectOrder = ({ state, commit }, id) => {
    commit("selectOrderToChangeStatus", id);
};

/////////////////////// Update Order Status ///////////////////////
export const updateOrderStatus = async (
    { state, commit, rootState, dispatch },
    data
) => {
    const { role } = rootState.auth.user;

    commit("setLoading", true);
    try {
        await axios.post(`/${role}/update-order-status/${data.id}`, data);
        dispatch(
            "flashMessage",
            {
                message: "Order status has been updated successfully",
                type: "success"
            },
            { root: true }
        );

        commit("setLoading", false);

        router.push({ name: "orders" });
    } catch (error) {
        console.log(error);
        commit("setLoading", false);
    }
};
