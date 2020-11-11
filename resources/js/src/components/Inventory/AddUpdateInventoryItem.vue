<template>
    <div class="add-update-inventory-component-wrapping-div">
        <b-row class="make-row-flex-centered" v-if="items">
          <form @submit.prevent="onFormSubmit">
            <div class="form-group row">
              <label for="itemId" class="col-md-2 col-form-label no-left-padding">Items</label>
              <div class="col-md-10">
                <select class="form-control" v-model="data.item_id"  :class="{ 'is-invalid': errors.item_id }">
                  <option disabled value="">Select Item</option>
                  <option :value="item.id" v-for="item in items" :key="item.id" :disabled="updateInventoryItem">{{ item.name }}</option>
                </select>
                <span class="invalid-feedback" v-if="errors.item_id">
                  <strong>{{ errors.item_id[0] }}</strong>
                </span>
              </div>
            </div>  

          <div class="form-group row">
            <label for="itemQuantity" class="col-md-2 col-form-label no-left-padding">Quantity</label>
            <div class="col-md-10">
              <input type="number" class="form-control" id="itemQuantity" v-model="data.quantity" :class="{ 'is-invalid': errors.quantity }">
              <span class="invalid-feedback" v-if="errors.quantity">
                <strong>{{ errors.quantity[0] }}</strong>
              </span>              
            </div>
          </div>

          <div class="form-group row">
            <label for="submitButton" class="col-md-2 col-form-label"></label>
            <div class="col-md-10">
              <button class="btn btn-success" type="submit">
                <template v-if="updateInventoryItem">Update</template>
                <template v-else>Add</template>
              </button>
              <button class='btn btn-danger' @click.prevent="clearInput">Cancel</button>
            </div>            
          </div>

          </form>
        </b-row>

    </div>
</template>

<script>
import { mapGetters, mapActions} from 'vuex';

export default {
    name: "AddUpdateInventoryItem",
    computed: { 
      ...mapGetters({
        items: 'items/items',
        errors: 'inventory/errors',
        selectedInventory: 'inventory/selectedInventory',
      }),
    },
    mounted() {
      //
    },
    watch: {
      selectedInventory(newValue, oldValue) {
        // console.log(`Updating from ${oldValue} to ${newValue}`);
        if(newValue) {
          this.data = newValue;
          this.updateInventoryItem = true;
        }
      }
    },
    data(){
      return { 
        data: { item_id: '', quantity: ''},
        updateInventoryItem: false,
      }
    },
    methods: {
      ...mapActions({
        clearErrors: 'inventory/clearErrors',
        addInventory: 'inventory/addInventory',
        updateInventoryItemMethod: 'inventory/updateInventoryItem',
        clearInventoryItemSelection: 'inventory/clearInventoryItemSelection',
      }),
      onFormSubmit() {
        if(this.updateInventoryItem) {
          this.updateInventoryItemMethod(this.data).then(() => this.clearInput());
        } else {
          this.addInventory(this.data).then(() => {
            this.clearInput()
          })
        }
      },
      clearInput() {
        this.data.item_id = '';
        this.data.quantity = '';
        this.clearErrors();
        this.clearInventoryItemSelection();
        this.updateInventoryItem = false;
      }
    }
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";

.make-row-flex-centered {
  display: flex;
  justify-content: center;
  align-items: center;
}

.no-left-padding {
  padding-left: 0px !important;
}


</style>
