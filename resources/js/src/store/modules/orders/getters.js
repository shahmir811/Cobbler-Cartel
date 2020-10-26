export const loading = state => state.loading;

export const orders = state => state.orders;

export const filteredOrders = state => state.filteredOrders;

export const countOrdersByStatus = state => {
    const result = _.groupBy(state.orders, "status");
    return result;
};
