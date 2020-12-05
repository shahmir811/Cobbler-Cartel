<template>
    <div class="revenue-page-wrapping-div">
        <h1 class="revenue-page-main-title">Account Management</h1>

        <div class="row" v-if="records !== null">
          <div class="col-md-8 offset-md-2">

            <div class="revenue-summary-div">
              <div
                  class="round-div-showing-revenue-status purchase-status"
              >
                  <p>{{ purchaseAmount }}</p>
                  <p>Purchase</p>
              </div>

              <div
                  class="round-div-showing-revenue-status sale-status"
              >
                  <p>{{ saleAmount }}</p>
                  <p>Sale</p>
              </div>

              <div
                  class="round-div-showing-revenue-status pending-status"
              >
                  <p>{{ dispatchAmount }}</p>
                  <p>Pending</p>
              </div>

            </div>

          </div>
        </div>

        <div class="row" v-if="records !== null">

          <div class="col-md-8 offset-md-2">

            <form @submit.prevent="getAllRevenue">
            <div class="row">

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="selectMonth">Month</label>
                    <select class="form-control" id="selectMonth" v-model="selectedMonth">
                      <option :value="month.id" v-for="month in records.months" :key="month.id">{{ month.name }}</option>
                    </select>
                  </div>              
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="selectYear">Year</label>
                    <select class="form-control" id="selectYear" v-model="selectedYear">
                      <option :value="year" v-for="year in records.years" :key="year">{{ year }}</option>
                    </select>
                  </div>              
                </div>   

                <div class="col-md-4">
                  <div class="form-group">
                    <button type="submit" class="btn btn-success custom-btn">Search</button>
                  </div>              
                </div>   
            </div>     
              </form>

          </div>
        </div>

        <div class="row">
          <div class="col-md-8 offset-md-2">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Type</th>                  
                  <th scope="col">Description</th>
                  <th scope="col">Amount (Rs)</th>
                  <th scope="col">Date</th>
                </tr>
              </thead>
              <tbody v-if="revenueList.length > 0">
                <tr v-for="revenue in revenueList" :key="revenue.id">
                  <td :class="revenue.type">{{ revenue.type }}</td>
                  <td class="text-left">{{ revenue.description }}</td>
                  <td>{{ revenue.amount }}</td>
                  <td>{{ revenue.created_at }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

    </div>
</template>

<script>

import { data } from './data';
import axios from '../../../store/BaseUrl';

export default {
    name: "RevenuePage",
    mounted() {
      this.records = data;
      this.getAllRevenue();
    },
    data() {
      return { 
        loading: false,
        revenueList: [],
        dispatchAmount: 0,
        selectedMonth: new Date().getMonth() + 1,
        selectedYear: new Date().getFullYear(),
        records: null,
        purchaseAmount: 0,
        saleAmount: 0,
      }
    },
    methods: {
      async getAllRevenue() {
        try {
          this.loading = true;
          const response = await axios.get(`/admin/revenues?month=${this.selectedMonth}&year=${this.selectedYear}`);
          this.revenueList = response.data.data.revenues;
          this.dispatchAmount = response.data.data.dispatchAmount;
          this.getSaleAndPurchaseAmount(this.revenueList);
          this.loading = false;

        } catch (error) {
          console.log(error);
          this.loading = false;          
        }
      },
      getSaleAndPurchaseAmount(revenueList) {
        let saleAmount = 0;
        let purchaseAmount = 0;
        revenueList.map(record => {
          if(record.type === 'Purchase') {
            purchaseAmount += parseInt(record.total);
          } else {
            saleAmount += parseInt(record.total);
          }
        })
        this.saleAmount = saleAmount;  
        this.purchaseAmount = purchaseAmount;
        // console.log("Sale Amount: ", this.saleAmount);
        // console.log("Purchase Amount: ", this.purchaseAmount);

      }
    },

};
</script>

<style lang="scss">

@import "../../../styles/styles.scss";

.revenue-page-main-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 30px 0px;  
}

.custom-btn {
  margin-top: 32px;
  width: 100%;
}

.Sale {
    color: $CONFIRMED;
}

.Purchase {
    color: $RED-3;
}


.round-div-showing-revenue-status {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    cursor: pointer;
    @extend .regular-16px-24px;
    
    p {
        margin-bottom: 0px;
    }
}


.revenue-summary-div {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.purchase-status{
    background: $RETURNED;
    &:hover {
        border: 5px solid darken($RETURNED, 30%);
    }
}

.sale-status{
    background: $PROCESSING;

    &:hover {
        border: 5px solid darken($PROCESSING, 30%);
    }  
}

.pending-status {
    background: $UPPER;
    &:hover {
        border: 5px solid darken($UPPER, 30%);
    }
}

</style>
