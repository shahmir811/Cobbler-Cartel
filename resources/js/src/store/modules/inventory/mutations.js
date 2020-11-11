export const setLoading = (state, trueOrFalse) => (state.loading = trueOrFalse);

export const clearErrors = state => (state.errors = []);

export const setError = (state, payload) => (state.errors = payload);

export const setInventoryList = (state, payload) =>
    (state.inventoryList = payload);

export const addToInventoryList = (state, payload) => {
    const inventoryItem = state.inventoryList.find(
        item => item.item_id === payload.item_id
    );
    if (inventoryItem) {
        inventoryItem.quantity = payload.quantity;
    } else {
        state.inventoryList.push(payload);
    }
};

export const selectInventoryItem = (state, id) => {
    const item = state.inventoryList.find(item => item.id === id);
    state.selectedInventory = { ...item };
};

export const removeInventoryItem = (state, id) => {
    state.inventoryList = state.inventoryList.filter(item => item.id !== id);
};

export const updateSelectedInventoryItem = (state, payload) => {
    const item = state.inventoryList.find(item => item.id === payload.id);
    item.quantity = payload.quantity;
};

export const clearSelectedInventroyItems = state => {
    state.selectedInventory = null;
};
