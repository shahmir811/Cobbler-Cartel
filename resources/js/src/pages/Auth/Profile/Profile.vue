<template>
    <div class="employee-profile-page-wrapping-div">
        <h1 class="employee-profile-page-main-title">My Profile</h1>

        <div v-if="user">
            <div class="form-group row">
              <div class="col-md-2 offset-md-4">
                <p class="label-class">Name:</p>
              </div>
              <div class="col-md-6">
                <p class="display-value">{{ user.name }}</p>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-2 offset-md-4">
                <p class="label-class">Email:</p>
              </div>
              <div class="col-md-6">
                <p class="display-value">{{ user.email }}</p>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-2 offset-md-4">
                <router-link to="/update-password" class="btn btn-success"><i class="fa fa-key" aria-hidden="true"></i> Update Password</router-link>
              </div>
            </div>

        </div>
    </div>
</template>

<script>

import { mapGetters, mapActions} from 'vuex';

export default {
    name: "EmployeeProfile",
    computed: {
      ...mapGetters({
        user: 'auth/user',
      })
    }
};
</script>

<style lang="scss">
@import "../../../styles/styles.scss";

.employee-profile-page-main-title{
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 30px 0px;
}

.make-it-flex-centered {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.employee-profile-page-label{
  @extend .semibold-16px-24px;
  text-align: left !important;
}

.label-class {
  font-size: 24px;
  font-weight: bold;
  color: black !important;
}

.display-value {
  margin-left: 20px;
  padding-top: 6px;
}

</style>
