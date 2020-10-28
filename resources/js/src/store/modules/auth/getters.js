export const loading = state => state.loading;

export const isAuthenticated = state => state.isAuthenticated;

export const user = state => state.user;

export const role = state => (state.user ? state.user.role : null);

export const errors = state => state.errors;
