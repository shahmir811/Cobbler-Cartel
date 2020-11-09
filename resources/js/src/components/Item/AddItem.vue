<template>
    <div class="add-item-component-wrapping-div">   

      <b-row class="make-row-flex-centered">       
        <form @submit.prevent="onFormSubmit">
          <div class="form-group row">
            <label for="itemName" class="col-md-2 col-form-label">Name</label>
            <div class="col-md-10">
              <input type="text" class="form-control" id="itemName" v-model="data.name" :class="{ 'is-invalid': errors.name }" >
              <span class="invalid-feedback" v-if="errors.name">
                <strong>{{ errors.name[0] }}</strong>
              </span>
            </div>
          </div>
          <div class="form-group row">
            <label for="itemPrice" class="col-md-2 col-form-label">Price</label>
            <div class="col-md-10">
              <input type="number" class="form-control" id="itemPrice" v-model="data.price" :class="{ 'is-invalid': errors.price }">
              <span class="invalid-feedback" v-if="errors.price">
                <strong>{{ errors.price[0] }}</strong>
              </span>              
            </div>
          </div>

          <div class="form-group row">
            <label for="submitButton" class="col-md-2 col-form-label"></label>
            <div class="col-md-10">
              <button class="btn btn-success" type="submit">
                <template v-if="updateItem">Update</template>
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

import { mapGetters, mapActions } from 'vuex';

export default {
    name: "AddItemComponent",
    computed: {
      ...mapGetters({
        loading: 'items/loading',
        errors: 'items/errors',
        selectedItem: 'items/selectedItem',
      })
    },
    mounted() {
      // 
    },
    data() {
      return { 
        data: { name: '', price: '' },
        updateItem: false,
      }
    },
    watch: {
      selectedItem(newValue, oldValue) {
        console.log(`Updating from ${oldValue} to ${newValue}`);
        if(newValue) {
          this.data = newValue;
          const properPrice = Number(newValue.price.replace(/[^0-9.-]+/g,""));
          this.data.price = properPrice;
          this.updateItem = true; 
        }
      }
    },
    methods: {
      ...mapActions({
        addNewItem: 'items/addNewItem',
        clearErrors: 'items/clearErrors',
        clearItemSelection: "items/clearItemSelection",
        updateItemDetails: 'items/updateItem'
      }),
      onFormSubmit() {
        if(this.updateItem) {
          this.updateItemDetails(this.data).then(() => this.clearInput())
        } else {
          this.addNewItem(this.data).then(() => this.clearInput())
        }
      },
    clearInput() {
      // this is vueJs Lifecycle method
      this.data.name = '';
      this.data.price = '';
      this.clearErrors();
      this.clearItemSelection();
      this.updateItem = false; 
    }
    },
};
</script>

<style lang="scss" scoped>
@import "../../styles/styles.scss";

.add-item-component-main-title {
  text-align: center;
  margin-bottom: 15px;
}

.make-row-flex-centered {
  display: flex;
  justify-content: center;
  align-items: center;
}

</style>
