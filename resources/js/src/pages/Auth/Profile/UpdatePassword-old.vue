<template>
  <div class="container">
    <div class="row">
      <div class="col col-md">
        <h1 class="text-center">Update Password</h1>
      </div>
    </div>

    <div class="row mt-15">
      <div class="col col-md-8">
        <form @submit.prevent="onSubmitHandler">
          <div class="form-group row">
            <label for="OldPassword" class="offset-sm-2 col-sm-4 col-form-label">Old Password</label>
            <div class="col-sm-6">
              <input
                type="password"
                class="form-control"
                id="OldPassword"
                v-model="record.old_password"
                :class="{'is-invalid': errors.old_password }"
              />
              <span class="invalid-feedback" v-if="errors.old_password">{{ errors.old_password[0] }}</span>
            </div>
          </div>
          <div class="form-group row">
            <label for="NewPassword" class="offset-sm-2 col-sm-4 col-form-label">New Password</label>
            <div class="col-sm-6">
              <input
                type="password"
                class="form-control"
                id="NewPassword"
                v-model="record.new_password"
                :class="{'is-invalid': errors.new_password }"
              />
              <span class="invalid-feedback" v-if="errors.new_password">{{ errors.new_password[0] }}</span>
            </div>
          </div>
          <div class="form-group row">
            <label
              for="ConfirmPassword"
              class="offset-sm-2 col-sm-4 col-form-label"
            >Confirm Password</label>
            <div class="col-sm-6">
              <input
                type="password"
                class="form-control"
                id="ConfirmPassword"
                v-model="record.confirm_password"
                :class="{'is-invalid': errors.confirm_password }"
              />
              <span
                class="invalid-feedback"
                v-if="errors.confirm_password"
              >{{ errors.confirm_password[0] }}</span>
            </div>
          </div>

          <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-6">
              <button type="submit" class="btn btn-primary" :disabled="loading">
                <template v-if="loading">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </template>
                <template v-else>Submit</template>
              </button>
              <router-link :to="{ name: 'profile' }" class="btn btn-danger">Cancel</router-link>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  name: "UpdatePassword",
  computed: {
    ...mapGetters({
      errors: "referrals/errors",
      loading: "referrals/loading",
      user: "auth/user"
    })
  },
  data() {
    return {
      record: {
        old_password: "",
        new_password: "",
        confirm_password: ""
      }
    };
  },
  methods: {
    ...mapActions({
      currentlyLoggedInUser: "referrals/currentlyLoggedInUser",
      flashMessage: "flashMessage"
    }),
    onSubmitHandler() {
      this.record.id = this.user.id;

      if (this.record.new_password !== this.record.confirm_password) {
        this.flashMessage({
          message: "New password must match with confirm password",
          type: "danger"
        });
        return false;
      }

      this.currentlyLoggedInUser(this.record);
    }
  }
};
</script>

<style lang="css">
form {
  display: inline;
}

.mt-15 {
  margin-top: 15px;
}
</style>