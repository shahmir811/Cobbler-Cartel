export const setLoading = (state, trueOrFalse) => (state.loading = trueOrFalse);

export const clearErrors = state => (state.errors = []);

export const setError = (state, payload) => (state.errors = payload);

export const setPurchasesList = (state, payload) =>
    (state.purchasesList = payload);

export const addToPurchaseList = (state, payload) => {
    state.purchasesList.push(payload);
};

export const clearselectedPurchase = state => (state.selectedPurchase = null);

export const removeFromPurchasesList = (state, id) => {
    state.purchasesList = state.purchasesList.filter(
        purchase => purchase.id !== id
    );
};

export const selectPurchaseItemToUpdate = (state, id) => {
    const item = state.purchasesList.find(item => item.id === id);
    state.selectedPurchase = { ...item };
};

export const updatePurchasesList = (state, payload) => {
    const item = state.purchasesList.find(item => item.id === payload.id);
    item.quantity = payload.quantity;
    item.total_amount = payload.total_amount;
};
