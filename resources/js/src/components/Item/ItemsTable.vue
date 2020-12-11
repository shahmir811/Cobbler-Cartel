<template>
    <div class="items-table-component-wrapping-div">

        <div class="row mb-10">
            <div class="col-md-2 offset-md-9">
                <a 
                    href="#" 
                    class="btn btn-success" 
                    :class="anyItemSelected ? '' : 'disabled'"
                    @click.prevent="downloadMultipleBarCodes"
                >
                    Download Barcodes
                </a>
            </div>
        </div>

        <b-row align-h="center">
          <b-col cols="10">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Price (Rs)</th>
                  <th scope="col">Item Code</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in items" :key="item.id">
                  <td>
                    <input 
                      type="checkbox" 
                      id="item.item_code" 
                      :value="item.item_code" 
                      v-model="selectedItems" 
                    />
                  </td>
                  <td>{{ ++index }}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.price }}</td>
                  <td>{{ item.item_code }}</td>
                  <td>
                    <a href="#" title="Generate BarCode" @click.prevent="generateAndDownloadBarCode(item.item_code)"
                        ><i
                            class="fa fa-barcode"
                            aria-hidden="true"
                        ></i
                    ></a>
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
import {generateAndDownloadBarcodeInPDF} from './generateBarcode'; 
import { getMultipleOrderNumbers } from './generateMultipleBarcodes';

export default {
    name: "ItemsTable",
    computed: { 
      ...mapGetters({
        items: 'items/items'
      }),
      anyItemSelected() {
        return this.selectedItems.length > 0 ? true : false;
      }
    },
    data() {
      return { 
        selectedItems: [],
      }
    },
    methods: {
      ...mapActions({
        selectItemToUpdate: "items/selectItemToUpdate",
        deleteItem: "items/deleteItem",
      }),
      generateAndDownloadBarCode(item_code) {
        generateAndDownloadBarcodeInPDF(item_code);
      },
      downloadMultipleBarCodes() {
        getMultipleOrderNumbers(this.selectedItems);
      },
      onDeleteHandler(id) {
          this.$swal
              .fire({
                  title: "Are you sure to delete this item?",
                  text: "All associated inventory items and purchases will also be deleted",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Yes, delete it!"
              })
              .then(result => {
                  if (result.value) {
                      this.deleteItem(id).then(() => {
                          this.$swal.fire(
                              "Deleted!",
                              "Item has been deleted.",
                              "success"
                          );
                      });
                  }
              });
      },      
    },
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";

.delete-record {
  color: $RED-3;
}


</style>
