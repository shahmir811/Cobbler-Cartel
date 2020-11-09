export const setLoading = (state, trueOrFalse) => (state.loading = trueOrFalse);

export const clearErrors = state => (state.errors = []);

export const setError = (state, payload) => (state.errors = payload);

export const setItems = (state, payload) => (state.items = payload);

export const addItem = (state, payload) => {
    state.items.push(payload);
};

export const removeItemFromList = (state, id) => {
    state.items = state.items.filter(item => item.id !== id);
};

export const updateItem = (state, modifiedItem) => {
    const item = state.items.find(item => item.id === modifiedItem.id);
    item.name = modifiedItem.name;
    item.price = modifiedItem.price;
};

export const getSelectedItems = (state, id) => {
    const item = state.items.find(item => item.id === id);
    state.selectedItem = { ...item };
};

export const clearSelectedItems = state => (state.selectedItems = null);
