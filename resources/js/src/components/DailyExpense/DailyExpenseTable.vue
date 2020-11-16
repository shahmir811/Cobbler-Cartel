<template>
    <div class="daily-expense-table-component-wrapping-div">
        <b-row align-h="center">
          <b-col cols="10">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Description</th>
                  <th scope="col">Amount (Rs)</th>
                  <th scope="col">Date</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr 
                  v-for="(item, index) in expenseList" 
                  :key="item.id"                 
                >
                  <td>{{ ++index }}</td>
                  <td>{{ item.description }}</td>
                  <td>{{ item.amount }}</td>
                  <td>{{ item.created_at }}</td>
                  <td>
                    <a href="#" class="delete-record" @click.prevent="onDeleteHandler(item.id)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </b-col>
        </b-row>        
    </div>
</template>

<script>

import { mapGetters, mapActions} from 'vuex';

export default {
    name: "DailyExpenseTable",
    computed: {
      ...mapGetters({
        expenseList: 'expenses/expenseList',
      })
    },
    methods: {
      ...mapActions({
        removeExpense: 'expenses/removeExpense',
      }),
      onDeleteHandler(id) {
          this.$swal
            .fire({
                title: "Are you sure to delete this record?",
                text: "You won't be able to revert this!'",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            })
            .then(result => {
                if (result.value) {
                    this.removeExpense(id).then(() => {
                        this.$swal.fire(
                            "Deleted!",
                            "Record has been deleted.",
                            "success"
                        );
                    });
                }
            });        
      }
    }
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";

</style>
