<template>
    <div class="scan-order-component-wrapping-div">

        <OrderDetailsModal
            :order="orderDetails"
            :showOrderDetailsModal="showOrderDetailsModal"
            :closeModal="closeModal"
        />

        <h1>Scan Orders</h1>

        <div class="row">
          <div class="col-md-6 offset-md-3">
              <input 
                  type="text" 
                  :readonly="loading" 
                  class="form-control" 
                  placeholder="Search Order no" 
                  v-model.lazy="searchOrder"
                />
          </div>
        </div>

        <div class="row mt-50" v-if="statuses">
          <div class="col-md-6 offset-md-3">
            <button class="btn btn-success full-width" :class="{ disabled: loading }" @click.prevent="updateOrderList">Update</button>
          </div>
        </div>

        <div class="row mt-20" v-if="statuses">
          <div class="col-md-6 offset-md-3">
            <table class="table table-borderless table-success">
              <thead>
                <tr>
                  <th scope="col">Order No</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="record in records" :key="record.id">
                  <td @click.prevent="selectOrderToViewDetails(record.id)" class="orderDetails">{{ record.order_no }}</td>
                  <td>
                    <select class="form-control" v-model="record.statuses_id">
                      <option :value="status.id" v-for="status in statuses" :key="status.id">{{ status.name  }}</option>
                    </select>
                  </td>
                  <td class="removeRecord">
                    <a href="#" :class="{ disabled: loading }" @click.prevent="removeRecord(record.order_no)">Remove</a>
                  </td>
                </tr>
              </tbody>
            </table>

          </div>
        </div>

    </div>
</template>

<script>

import axios from '../../store/BaseUrl';
import { mapGetters, mapActions } from 'vuex';
import _ from 'lodash';
import OrderDetailsModal from "./OrderDetailsModal";

export default {
    name: "ScanOrders",
    mounted() {
      this.getAllStatuses();
    },
    components: {
      OrderDetailsModal
    },
    computed: {
      ...mapGetters({
        user: 'auth/user',
      })
    },
    watch: {
      searchOrder(newValue, oldValue) {
        if(newValue) {
          this.getOrder(newValue);
        }
      }

    },
    data() {
      return { 
        loading: false,
        searchOrder: '',
        statuses: [],
        records: [],
        showOrderDetailsModal: false,
        orderDetails: null,
        recordsList: [
          {id: 1, order_no: "4250632501512", statuses_id: 2, status: "confirmed"},
          {id: 3, order_no: "6001087357258", statuses_id: 2, status: "bottom"},
          {id: 5, order_no: "9780141016405", statuses_id: 2, status: "upper"}
        ],
      }
    },
    methods: {
      async getOrder(comingValue) {
        let value = comingValue;
        this.searchOrder = ''

        if(!this.checkIfOrderNoAlreadyExistsInRecordsArray(value)) {
          try {
            this.loading = true;

            if(!this.user) {
              return false;
            }
            const response = await axios.get(`/${this.user.role}/getOrder/${value}`);
            this.records.push(response.data.data.order);

            this.loading = false;
            
          } catch (error) {
            console.log(error);
            this.loading = false;
          }
        }

      },
      async getAllStatuses() {
        try {
          
          if(!this.user) {
            return false;
          }

          const response = await axios.get(`/${this.user.role}/getAllStatuses`);
          this.statuses = response.data.data.statuses;
        } catch (error) {
          console.log(error);
        }
      },
      removeRecord(order_no) {
        this.records = this.records.filter(record => record.order_no !== order_no);
        // this.recordsList = this.recordsList.filter(record => record.order_no !== order_no);
      },
      checkIfOrderNoAlreadyExistsInRecordsArray(order_no) {

        const order = this.records.find(record => record.order_no === order_no);

        return order ? true : false;
      },
      async updateOrderList() {

        if(this.records.length > 0) {
          try {

            if(!this.user) {
              return false;
            }

            this.loading = true;
            await axios.post(`/${this.user.role}/updateOrderList`, {
              records: this.records
            });

            this.records = [];
            this.loading = false;
            // this.recordsList = [];
          } catch (error) {
            console.log(error);
            this.loading = false;
          }
        }
      },
      selectOrderToViewDetails(id) {
        this.orderDetails = this.records.find(record => record.id === id);
        this.showOrderDetailsModal = true;
      },
      closeModal() {
        this.orderDetails = null;
        this.showOrderDetailsModal = false;
      },    
    }
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";

.full-width {
  width: 100%;
}

.removeRecord {
  @extend .pt-20;

  a {
    color: red !important;
  }
}

.orderDetails {
  cursor: pointer;

  &:hover {
    text-decoration: underline;
  }
}

</style>
