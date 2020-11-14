<template>
  <div class="body">
    <div class="main">
      <h1>404</h1>
      <h3>Page Not Found</h3>
      <template v-if="isAuthenticated">
        <router-link class="link" to="/home">Go to Home Page</router-link>
      </template>
      <template v-else>
        <router-link class="link" to="/">Go to Home Page</router-link>
      </template>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "NotFound",
  computed: {
    ...mapGetters({
      isAuthenticated: "auth/isAuthenticated"
    })
  }
};
</script>

<style lang="css">
.body {
  width: 100%;
  height: 70vh;
  background-color: #f1f1f1;
  margin: 0;
  padding: 0;
  display: -webkit-flex;
  display: -moz-flex;
  display: -ms-flex;
  display: -o-flex;
  display: flex;
  font-family: sans-serif;
}
.main {
  -ms-align-items: center;
  align-items: center;
  justify-content: center;
  width: 100%;
  text-align: center;
}
.main h1 {
  text-align: center;
  font-size: 220px;
  margin-top: 0px;
  margin-bottom: 0px;
}
.main h3 {
  font-size: 50px;
  margin: 10px auto;
}
.main .link {
  text-decoration: none;
  color: red;
}
</style>