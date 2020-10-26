export const setLoading = (state, trueOrFalse) => (state.loading = trueOrFalse);

export const setOrders = (state, orders) => (state.orders = orders);

export const filterMyOrders = (state, status) => {
    state.filteredOrders = state.orders;

    if (status) {
        state.filteredOrders = state.filteredOrders.filter(
            order => order.status === status
        );
    }
};
