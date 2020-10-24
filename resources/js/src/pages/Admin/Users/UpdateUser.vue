<template>
    <div class="admin-add-new-user-wrapping-div">
        <h2>Update User page</h2>

        <b-row align-h="center" v-if="form">
            <b-col cols="8">
                <b-form @submit.prevent="submitForm">
                    <b-form-group
                        id="input-group-1"
                        label="Name:"
                        label-for="input-1"
                        class="input-form-label"
                    >
                        <b-form-input
                            id="input-1"
                            v-model="form.name"
                            placeholder="Enter name"
                            :class="{ 'is-invalid': errors.name }"
                        ></b-form-input>
                        <span
                            class="invalid-feedback left-text"
                            v-if="errors.name"
                        >
                            <strong>{{ errors.name[0] }}</strong>
                        </span>
                    </b-form-group>

                    <b-form-group
                        id="input-group-2"
                        label="Email address:"
                        label-for="input-2"
                        class="input-form-label"
                    >
                        <b-form-input
                            id="input-2"
                            v-model="form.email"
                            type="email"
                            placeholder="Enter email"
                            :class="{ 'is-invalid': errors.email }"
                        ></b-form-input>
                        <span
                            class="invalid-feedback left-text"
                            v-if="errors.email"
                        >
                            <strong>{{ errors.email[0] }}</strong>
                        </span>
                    </b-form-group>

                    <b-form-group
                        id="input-group-3"
                        label="Role:"
                        label-for="input-3"
                        class="input-form-label"
                    >
                        <b-form-select
                            v-model="form.role_id"
                            :options="roles"
                        ></b-form-select>
                    </b-form-group>

                    <b-form-group
                        id="input-group-4"
                        label="Password:"
                        label-for="input-4"
                        class="input-form-label"
                    >
                        <b-form-input
                            type="password"
                            id="input-4"
                            v-model="form.password"
                            placeholder="Enter password"
                            :class="{ 'is-invalid': errors.password }"
                        ></b-form-input>
                        <span
                            class="invalid-feedback left-text"
                            v-if="errors.password"
                        >
                            <strong>{{ errors.password[0] }}</strong>
                        </span>
                    </b-form-group>

                    <b-button
                        type="submit"
                        variant="success"
                        class="admin-add-user-add-button"
                        :disabled="loading"
                    >
                        <template v-if="loading"
                            ><b-spinner small label="Small Spinner"></b-spinner
                        ></template>
                        <template v-else>Update</template>
                    </b-button>
                    <router-link
                        to="/admin/users"
                        class="btn btn-danger admin-add-user-cancel-button"
                        >Cancel</router-link
                    >
                </b-form>
            </b-col>
        </b-row>
        <b-row v-else>
            <div class="text-center">
                <b-spinner label="Spinning"></b-spinner>
            </div>
        </b-row>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: "Admin-Update-User",
    computed: {
        ...mapGetters({
            users: "user/users",
            updateUser: "user/updateUser",
            errors: "user/errors",
            loading: "user/loading"
        })
    },
    mounted() {
        this.selectUserToUpdate(this.$route.params.id);
        this.form = { ...this.updateUser };
        this.form.role_id = this.form.role === "admin" ? 1 : 2;
        this.form.password = "";
    },
    data() {
        return {
            form: this.updateUser,
            roles: [
                { value: 1, text: "Admin" },
                { value: 2, text: "Employee" }
            ]
        };
    },
    methods: {
        ...mapActions({
            UpdateUserDetails: "user/UpdateUserDetails",
            selectUserToUpdate: "user/selectUserToUpdate"
        }),
        submitForm() {
            this.UpdateUserDetails(this.form);
        }
    }
};
</script>

<style lang="scss"></style>
