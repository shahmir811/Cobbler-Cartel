<template>
    <div class="add-daily-expense-component-wrapping-div">

        <div class="row">
          <div class="col-md-8 offset-md-2">

            <form @submit.prevent='onFormSubmit'>
              <div class="form-group row">
                <label for="description" class="col-md-2 col-form-label no-left-padding">Description</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="description" v-model="data.description" :class="{ 'is-invalid': errors.description }">
                  <span class="invalid-feedback" v-if="errors.description">
                    <strong>{{ errors.description[0] }}</strong>
                  </span>              
                </div>
              </div>

              <div class="form-group row">
                <label for="amount" class="col-md-2 col-form-label no-left-padding">Amount</label>
                <div class="col-md-4">
                  <input type="number" class="form-control" id="amount" v-model="data.amount" :class="{ 'is-invalid': errors.amount }">
                  <span class="invalid-feedback" v-if="errors.amount">
                    <strong>{{ errors.amount[0] }}</strong>
                  </span>              
                </div>
              </div>  

              <div class="form-group row">
                <label for="submitButton" class="col-md-2 col-form-label"></label>
                <div class="col-md-4">
                  <button class="btn btn-success" type="submit">
                    <template>Add</template>
                  </button>
                  <button class='btn btn-danger' @click.prevent="clearInput">Cancel</button>
                </div>            
              </div>                          

            </form>

          </div>
        </div>
    </div>
</template>

<script>

import { mapGetters, mapActions} from 'vuex';


export default {
    name: "AddDailyExpense",
    computed: {
      ...mapGetters({
        loading: 'expenses/loading',
        errors: 'expenses/errors',
      })
    },
    data() {
      return { 
        data: { description: '', amount: ''}
      }
    },
    methods: {
      ...mapActions({
        addExpense: 'expenses/addExpense',
        clearErrors: 'expenses/clearErrors',
        addExpense: 'expenses/addExpense',
      }),
      onFormSubmit() {
        this.addExpense(this.data).then(() => this.clearInput());
      },
      clearInput() {
        this.data.description = '';
        this.data.amount = '';       
        this.clearErrors(); 
      }
    },
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";


</style>
