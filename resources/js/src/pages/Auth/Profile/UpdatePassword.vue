<template>
    <div class="update-password-page-wrapping-div">
        <h1 class="update-password-page-main-title">Update Password</h1>


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
              <button type="submit" class="btn btn-success" :disabled="loading">
                <template v-if="loading">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </template>
                <template v-else>Submit</template>
              </button>
              <router-link :to="{ name: 'my-profile' }" :class="{ disabled: loading }" class="btn btn-danger">Cancel</router-link>
            </div>
          </div>
        </form>
      </div>
    </div>

    </div>
</template>

<script>

import { mapGetters, mapActions} from 'vuex';
import axios from '../../../store/BaseUrl';

export default {
    name: "UpdatePassword",
    computed: {
      ...mapGetters({
          user: "auth/user"
      })
    },
  data() {
    return {
      record: {
        old_password: "",
        new_password: "",
        confirm_password: ""
      },
      errors: [],
      loading: false,
    };
  },
  methods: {
    ...mapActions({
      flashMessage: "flashMessage"
    }),
    async onSubmitHandler() {
      this.record.id = this.user.id;
      this.errors = [];

      if (this.record.new_password !== this.record.confirm_password) {
        this.flashMessage({
          message: "New password must match with confirm password",
          type: "danger"
        });
        return false;
      }

      this.loading = true;


      try {
        const role = 'employee';

        const response = await axios.post(`/${role}/update-password/${this.record.id}`, this.record);

        this.flashMessage({
          message: "Password updated successfully",
          type: "success"
        });        

        this.loading = false;
        this.$router.push({ name: 'my-profile' });

      } catch (error) {
        console.log(error);
        this.errors = error.response.data.errors;
        this.loading = false;
      }

    }
  },
};
</script>

<style lang="scss">

@import "../../../styles/styles.scss";

.update-password-page-main-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 30px 0px;  
}

form {
  display: inline;
}

.mt-15 {
  margin-top: 15px;
}

.disabled {
    opacity: 0.5;
    pointer-events: none;
}

</style>
