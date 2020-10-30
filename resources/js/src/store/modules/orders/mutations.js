export const setLoading = (state, trueOrFalse) => (state.loading = trueOrFalse);

export const setOrders = (state, orders) => (state.orders = orders);

export const filterMyOrders = (state, status) => {
    state.filteredOrders = state.orders;

    if (status !== "processing") {
        state.filteredOrders = state.filteredOrders.filter(
            order => order.status === status
        );
    }
};

export const getNoFilterRecord = state => (state.filteredOrders = state.orders);

export const getSpecificRecords = (state, orderNo) => {
    state.filteredOrders = state.orders;

    if (orderNo) {
        state.filteredOrders = state.orders.filter(order => {
            return Object.keys(order).some(key => {
                // return String(order[key]).indexOf(orderNo) > -1;
                return String(order["order_no"]).indexOf(orderNo) > -1;
            });
        });
    }
};

export const removeOrderFromOrdersList = (state, orderNo) => {
    // removing from orders array
    state.orders = state.orders.filter(order => order.order_no !== orderNo);

    // removing from filteredOrders array
    state.filteredOrders = state.filteredOrders.filter(
        order => order.order_no !== orderNo
    );
};

export const viewOrderNo = (state, id) => {
    state.viewOrderDetails = state.orders.find(order => order.id === id);
};

export const resetOrdersState = state => {
    state.orders = [];
    state.loading = false;
    state.filteredOrders = [];
    state.viewOrderDetails = null;
};

export const removeCompleteOrder = (state, orderNo) => {
    state.orders = state.orders.filter(order => order.order_no !== orderNo);
    state.filteredOrders = state.filteredOrders.filter(
        order => order.order_no !== orderNo
    );
};

export const selectOrderToChangeStatus = (state, id) => {
    state.selectOrderToUpdateStatus = state.filteredOrders.find(
        order => order.id === id
    );
};

export const receivedAllCompletedOrders = state => {
    state.filteredOrders = state.orders;
};
