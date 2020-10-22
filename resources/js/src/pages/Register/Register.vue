<template>
    <div class="register-page-wrapping-div">
        <div class="register-page-box">
            <b-form @submit.prevent="onSubmit">
                <b-form-group
                    id="input-group-1"
                    label="Email address:"
                    label-for="input-1"
                    class="register-page-email-group-div"
                >
                    <b-form-input
                        id="input-1"
                        v-model="form.email"
                        type="text"
                        placeholder="Enter email"
                    ></b-form-input>
                </b-form-group>

                <b-form-group
                    id="input-group-2"
                    label="Password:"
                    label-for="input-2"
                    class="register-page-password-group-div"
                >
                    <b-form-input
                        id="input-2"
                        v-model="form.password"
                        type="password"
                        placeholder="Enter Password"
                    ></b-form-input>
                </b-form-group>

                <b-button type="submit" class="register-page-submit-button">
                    Submit
                </b-button>
            </b-form>
            <router-link to="/register" class="goto-register-page">
                Dont have an account
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "Register",
    data() {
        return {
            form: {
                email: "",
                password: ""
            }
        };
    }, // data ends here
    methods: {
        onSubmit(e) {
            e.preventDefault();
            console.log("EMAIL: ", this.form.email);
            console.log("PASSWORD: ", this.form.password);
        }
    } // methods end here
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";

.register-page-wrapping-div {
    display: flex;
    justify-content: center;
    align-items: center;
}

.register-page-box {
    width: 567px;
    height: 487px;
    margin-top: 50px;
    background: $BROWN-5;
    padding: 30px 15px 0px;
    border: 5px solid $BROWN-10;
    box-shadow: 0px 2px 2px 0px $BROWN-5;
}

.register-page-submit-button {
    width: 117px;
    height: 45px;
    background: $BROWN-10;
    @extend .semibold-16px-24px;
    color: $GREY-2;

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

.register-page-email-group-div {
    margin-bottom: 25px;
    label {
        @extend .semibold-16px-24px;
        color: $BROWN-10;
    }
}

.register-page-password-group-div {
    margin-bottom: 25px;
    label {
        @extend .semibold-16px-24px;
        color: $BROWN-10;
    }
}
</style>
