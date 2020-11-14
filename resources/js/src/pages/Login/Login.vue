<template>
    <div class="login-page-wrapping-div">
        <div class="login-page-box">
            <h1 class="login-page-login-title">Login</h1>
            <b-form @submit.prevent="onSubmit">
                <b-form-group
                    id="input-group-1"
                    label="Email address:"
                    label-for="input-1"
                    class="login-page-email-group-div"
                >
                    <b-form-input
                        id="input-1"
                        v-model="form.email"
                        type="text"
                        placeholder="Enter email"
                        :class="{ 'is-invalid': errors.email }"
                    ></b-form-input>
                    <span class="invalid-feedback" v-if="errors.email">
                        <strong>{{ errors.email[0] }}</strong>
                    </span>
                </b-form-group>

                <b-form-group
                    id="input-group-2"
                    label="Password:"
                    label-for="input-2"
                    class="login-page-password-group-div"
                >
                    <b-form-input
                        id="input-2"
                        v-model="form.password"
                        type="password"
                        placeholder="Enter Password"
                    ></b-form-input>
                </b-form-group>

                <router-link to="/forgot-password" class="goto-forgot-password-page">
                    Forgot password
                </router-link>

                <b-button
                    type="submit"
                    class="login-page-submit-button"
                    :disabled="loading"
                >
                    <template v-if="loading"
                        ><b-spinner small label="Small Spinner"></b-spinner
                    ></template>
                    <template v-else>Submit</template>
                </b-button>
            </b-form>

        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: "Login",
    computed: {
        ...mapGetters({
            loading: "auth/loading",
            errors: "auth/errors"
        })
    },
    data() {
        return {
            form: {
                email: "",
                password: ""
            }
        };
    }, // data ends here
    methods: {
        ...mapActions({
            loginUser: "auth/loginUser",
            removeAllErrors: "auth/removeAllErrors"
        }),
        onSubmit(e) {
            e.preventDefault();
            this.loginUser(this.form);
            // console.log("EMAIL: ", this.form.email);
            // console.log("PASSWORD: ", this.form.password);
        }
    } // methods end here
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";

.login-page-wrapping-div {
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-page-box {
    width: 567px;
    height: 487px;
    margin-top: 50px;
    background: $BROWN-5;
    padding: 30px 15px 0px;
    border: 5px solid $BROWN-10;
    box-shadow: 0px 2px 2px 0px $BROWN-5;
}

.goto-forgot-password-page {
    display: block;
    margin: -10px 0px 10px;
    color: $BROWN-10;
    font-weight: bold;
    text-decoration: underline;

    &:hover {
        text-decoration: none;
    }
}

.login-page-submit-button {
    width: 117px;
    height: 45px;
    background: $BROWN-10 !important;
    @extend .semibold-16px-24px;
    color: $GREY-2 !important;

    &:hover {
        @extend .semibold-16px-24px;
        background: $GREY-2 !important;
        color: $BROWN-10 !important;
        outline: none;
        border: none;
    }
}

.goto-register-page {
    @extend .regular-12px-20px;
    color: $GREY-2 !important;
}

.login-page-email-group-div {
    margin-bottom: 25px;
    label {
        @extend .semibold-16px-24px;
        color: $BROWN-10;
    }
}

.login-page-password-group-div {
    margin-bottom: 25px;
    label {
        @extend .semibold-16px-24px;
        color: $BROWN-10;
    }
}

.login-page-login-title {
    text-align: center;
    color: $BROWN-10 !important;
    text-decoration: underline;
    margin-bottom: 50px;
}
</style>
