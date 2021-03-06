import axios from "../../BaseUrl";
import router from "../../../routes/router";

/////////////////////// Fetch All Orders ///////////////////////
export const getAllOrders = async ({ state, commit, rootState, dispatch }) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;

    commit("setLoading", true);
    try {
        const response = await axios.get(`/${role}/orders`);
        commit("setOrders", response.data.data.orders);
        commit("filterMyOrders");
        commit("getNoFilterRecord");

        commit("setLoading", false);
    } catch (error) {
        console.log(error);

        commit("setLoading", false);
    }
};

/////////////////////// Fetch All orders From Update order status ///////////////////////
export const getAllOrdersFromChangeOrderStatusPage = (
    { state, commit, rootState, dispatch },
    id
) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;

    commit("setLoading", true);
    return new Promise((resolve, reject) => {
        axios
            .get(`/${role}/orders`)
            .then(response => {
                commit("setOrders", response.data.data.orders);
                commit("filterMyOrders");
                commit("getNoFilterRecord");
                commit("setLoading", false);
                commit("selectOrderToChangeStatus", id);
                resolve();
            })
            .catch(error => {
                console.log(error);
                commit("setLoading", false);
                reject();
            });
    });
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
    orderNo
) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;

    try {
        await axios.delete(`/${role}/orders/${orderNo}`);

        dispatch(
            "flashMessage",
            {
                message: "Order deleted successfully",
                type: "success"
            },
            { root: true }
        );

        commit("removeOrderFromOrdersList", orderNo);
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
export const markOrderAsComplete = async (
    { state, commit, rootState },
    orderNo
) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;

    try {
        await axios.get(`/${role}/mark-order-as-complete/${orderNo}`);

        commit("removeCompleteOrder", orderNo);
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
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;

    commit("setLoading", true);
    try {
        await axios.post(`/${role}/update-order-status/${data.orderNo}`, data);
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

/////////////////////// Get AllCompleted Orders ///////////////////////
export const getAllCompletedOrders = async ({
    state,
    commit,
    rootState,
    dispatch
}) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;
    commit("setLoading", true);
    try {
        const response = await axios.get(`/${role}/get-all-completed-orders`);
        commit("setOrders", response.data.data.orders);
        commit("receivedAllCompletedOrders");

        commit("setLoading", false);
    } catch (error) {
        console.log(error);
        commit("setLoading", false);
    }
};
