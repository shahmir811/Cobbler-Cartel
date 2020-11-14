<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mt-50">
          <div class="card-header changeBack">Forgot Password</div>

          <div class="card-body">
            <form @submit.prevent="onSubmitHandler">
              <div class="form-group row">
                <label for="verification_key" class="col-md-4 col-form-label text-md-right">Verification Key:</label>

                <div class="col-md-6">
                  <input
                    id="verification_key"
                    type="text"
                    class="form-control"
                    autocomplete="verification_key"
                    v-model="user.verification_key"
                    :class="{'is-invalid': errors.verification_key }"
                  />
                  <span
                    class="invalid-feedback"
                    v-if="errors.verification_key"
                  >{{ errors.verification_key[0] }}</span>
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                <div class="col-md-6">
                  <input
                    id="password"
                    type="password"
                    class="form-control"
                    autocomplete="new-password"
                    v-model="user.new_password"
                    :class="{'is-invalid': errors.new_password }"
                  />
                  <span
                    class="invalid-feedback"
                    v-if="errors.new_password"
                  >{{ errors.new_password[0] }}</span>
                </div>
              </div>              

              <div class="form-group row">
                <label
                  for="password-confirm"
                  class="col-md-4 col-form-label text-md-right"
                >Confirm Password</label>

                <div class="col-md-6">
                  <input
                    id="password-confirm"
                    type="password"
                    class="form-control"
                    autocomplete="new-password"
                    v-model="user.password_confirmation"
                  />
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary" :disabled="loading">
                    <template v-if="loading">
                      <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                    </template>
                    <template v-else>Submit</template>
                  </button>

                  <router-link class="btn btn-link" :class="{ disabled: loading }" to="/login">Cancel</router-link>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  name: "PasswordReset",
  mounted() {},
  computed: {
    ...mapGetters({
      loading: "loading",
      errors: "errors"
    })
  },
  data() {
    return {
      user: {
        new_password: "",
        password_confirmation: "",
        verification_key: "",
        slug: this.$route.query.referral
      }
    };
  },
  methods: {
    ...mapActions({
      resetPassword: "resetPassword",
      flashMessage: "flashMessage"
    }),
    onSubmitHandler() {
      if (this.user.new_password !== this.user.password_confirmation) {
        this.flashMessage({
          message: "New password must match with confirm password",
          type: "danger"
        });
        return false;
      }
      this.resetPassword(this.user);
    }
  }
};
</script>

<style lang="scss">

@import "../../styles/styles.scss";

.mt-50 {
  margin-top: 50px;
}

.changeBack {
  background: $BROWN-5 !important;
}

.disabled {
    opacity: 0.5;
    pointer-events: none;
}


</style>