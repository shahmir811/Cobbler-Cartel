<template>
    <div class="admin-add-new-user-wrapping-div">
        <h1>Create New User</h1>

        <b-row align-h="center">
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

                    <b-form-group
                        id="input-group-5"
                        label="Confirm Password:"
                        label-for="input-5"
                        class="input-form-label"
                    >
                        <b-form-input
                            type="password"
                            id="input-5"
                            v-model="form.confirmPassword"
                            placeholder="Confirm Password"
                        ></b-form-input>
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
                        <template v-else>Add</template>
                    </b-button>
                    <router-link
                        to="/users"
                        class="btn btn-danger admin-add-user-cancel-button"
                        >Cancel</router-link
                    >
                </b-form>
            </b-col>
        </b-row>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: "Add-user",
    computed: {
        ...mapGetters({
            loading: "user/loading",
            errors: "user/errors"
        })
    },
    data() {
        return {
            form: {
                name: "",
                email: "",
                role_id: 2,
                password: "",
                confirmPassword: ""
            },
            roles: [
                { value: 1, text: "Admin" },
                { value: 2, text: "Employee" }
            ]
        };
    },
    methods: {
        ...mapActions({
            addNewUser: "user/addNewUser",
            flashMessage: "flashMessage"
        }),
        submitForm() {
            if (this.form.password !== this.form.confirmPassword) {
                this.flashMessage({
                    message: "Password mismatch error",
                    type: "danger"
                });
                return;
            }

            this.addNewUser(this.form);
        }
    }
};
</script>

<style lang="scss">
@import "../../../styles/styles.scss";

.admin-add-new-user-wrapping-div {
    margin: 15px 0px;
}

.input-form-label {
    label {
        text-align: left;
        @extend .semibold-16px-24px;
        color: $BROWN-10;
        margin-bottom: 20px;
    }
}

.admin-add-user-add-button {
    width: 117px;
    height: 45px;
}

.admin-add-user-cancel-button {
    width: 117px;
    height: 45px;
    padding-top: 10px;
}

.left-text {
    text-align: left;
}
</style>
