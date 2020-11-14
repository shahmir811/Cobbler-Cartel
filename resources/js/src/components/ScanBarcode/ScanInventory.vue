<template>
    <div class="scan-inventory-component-wrapping-div">
        <h1>Scan Inventory</h1>

        <div class="row">
          <div class="col-md-6 offset-md-3">
              <input 
                  type="text" 
                  :readonly="loading" 
                  class="form-control" 
                  placeholder="Search Item Code" 
                  v-model.lazy="searchItemCode"
                />
          </div>
        </div>

        <div class="row mt-50">
          <div class="col-md-6 offset-md-3">
            <button class="btn btn-success full-width" :class="{ disabled: loading }" @click.prevent="updateInventoryItems">Update</button>
          </div>
        </div>

        <div class="row mt-20" v-if="records.length > 0">
          <div class="col-md-6 offset-md-3">
            <table class="table table-borderless table-success">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Item Code</th>
                  <th scope="col">Add/Subtact Quantity</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="record in records" :key="record.id">
                  <td>{{ record.name }}</td>
                  <td>{{ record.item_code }}</td>
                  <td>
                    <input type="number" class='form-control' v-model="record.quantity" />
                  </td>
                  <td class="removeRecord">
                    <a href="#" :class="{ disabled: loading }" @click.prevent="removeRecord(record.item_code)">Remove</a>
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
import { mapGetters, mapActions} from 'vuex';
import _ from 'lodash';

export default {
    name: "ScanInventory",
    computed: {
      ...mapGetters({
        user: 'auth/user',
      }),
    },
    data() {
      return {
        searchItemCode: '', 
        loading: false,
        records: [],
        recordsList: [
          {id: 1, name: "Brown leather", item_code: "4250632501512", price: "1,200.00"},
          {id: 2, name: "Black leather", item_code: "6001087357258", price: "1,350.00"},
          {id: 3, name: "Shoe Buckels", item_code: "9780141016405", price: "230.00"},
        ]
      }
    },
    watch: {
      searchItemCode(newValue, oldValue) {
        if(newValue) {
          this.getInventoryItem(newValue);
        }
      }

    },    
    methods: {
      async getInventoryItem(comingValue) {
        let value = comingValue;
        this.searchItemCode = '';

        if(!this.checkIfItemCodeAlreadyExistsInRecordsArray(value)) {
          this.loading = true;

          try {
            
            const response = await axios.get(`/${this.user.role}/getItem/${value}`);
            let item = response.data.data.item;
            item.quantity = 0;
            this.records.push(item);

            this.loading = false;
          } catch (error) {
              console.log(error);
              this.loading = false;
          }


        }

      },
      async updateInventoryItems() {
        if(this.records.length > 0) {

          try {
            this.loading = true;
            
            await axios.post(`/${this.user.role}/updateItemsList`, {
              records: this.records
            });

            this.loading = false;   
            this.records = []
            // this.recordsList = []
            
          } catch (error) {
              console.log(error);
              this.loading = false;            
          }

        }
      },
      removeRecord(item_code) {
        this.records = this.records.filter(record => record.item_code !== item_code);
        // this.recordsList = this.recordsList.filter(record => record.item_code !== item_code);
      },
      checkIfItemCodeAlreadyExistsInRecordsArray(item_code) {

        const item = this.records.find(record => record.item_code === item_code);

        return item ? true : false;
      },      
    }
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";


.removeRecord {
  @extend .pt-20;

  a {
    color: red !important;
  }
}


</style>
