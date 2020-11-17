<template>
    <div class="logs-page-wrapping-div">
        <h1 class="logs-page-main-title">Logs</h1>

        <div class="row">
          <div class="col-md-8 offset-md-2">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">User</th>                  
                  <th scope="col">Description</th>
                  <th scope="col">Date</th>
                </tr>
              </thead>
              <tbody v-if="logsList.length > 0">
                <tr v-for="log in logsList" :key="log.id">
                  <td>{{ log.user }}</td>
                  <td class="text-left">{{ log.description }}</td>
                  <td>{{ log.created_at }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
</template>

<script>

import axios from '../../../store/BaseUrl';

export default {
    name: "Logs",
    mounted() {
      this.getAllLogs();
    },
    data() {
      return { 
        loading: false,
        logsList: [],
      }
    },
    methods: {
      async getAllLogs() {
        try {
          this.loading = true;
          const response = await axios.get(`/admin/logs`);
          this.logsList = response.data.data.logs;

          this.loading = false;

        } catch (error) {
          console.log(error);

          this.loading = false;          
        }
      },
    },

};
</script>

<style lang="scss">

@import "../../../styles/styles.scss";

.logs-page-main-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 30px 0px;  
}


</style>
