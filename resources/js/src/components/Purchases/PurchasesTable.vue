<template>
    <div class="purchases-table-component-wrapping-div">
        <b-row align-h="center">
          <b-col cols="10">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total Amount (Rs)</th>
                  <th scope="col">Purchased On</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in purchasesList" :key="item.id">
                  <td>{{ ++index }}</td>
                  <td>{{ item.item_name }}</td>
                  <td>{{ item.quantity }}</td>
                  <td>{{ item.total_amount }}</td>
                  <td>{{ item.created_at }}</td>
                  <td>
                    <a href="#" @click.prevent="selectItemToUpdate(item.id)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
    name: "PurchasesTable",
    computed: {
      ...mapGetters({
        purchasesList: 'purchases/purchasesList'
      })
    },
    methods: {
      ...mapActions({
        deletePurchaseItem: 'purchases/deletePurchaseItem',
        selectPurchaseItemToUpdate: "purchases/selectPurchaseItemToUpdate"
      }),
      selectItemToUpdate(id) {
        this.selectPurchaseItemToUpdate(id);
      },
      onDeleteHandler(id) {
          this.$swal
            .fire({
                title: "Are you sure to delete this purchase item?",
                text: "You won't be able to revert this!'",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            })
            .then(result => {
                if (result.value) {
                    this.deletePurchaseItem(id).then(() => {
                        this.$swal.fire(
                            "Deleted!",
                            "Purchase item has been deleted.",
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
