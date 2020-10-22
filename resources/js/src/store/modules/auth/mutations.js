import localForage from "localforage";
import { isEmpty } from "lodash";

export const startLoading = state => (state.loading = true);

export const endLoading = state => (state.loading = false);

export const clearErrors = state => (state.errors = []);

export const setError = (state, payload) => (state.errors = payload);

export const errors = state => state.errors;
