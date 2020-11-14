<template>
    <div class="scan-bar-code-page-wrapping-div">
        <h1 class="scan-bar-code-page-main-title">Scan BarCode</h1>

        <div class='row mt-50'>
          <div class="col-md-4 offset-md-2">
            <button class="basic-button" :class="{selected: type === 'orders'}" @click.prevent="changeType('orders')">Scan Orders</button>
          </div>
          <div class="col-md-4">
            <button class="basic-button" :class="{selected: type === 'inventory'}" @click.prevent="changeType('inventory')">Scan Inventory</button>
          </div>
        </div>


        <div class='mt-50'>
          <ScanOrders v-if="type === 'orders'" />

          <ScanInventory v-if="type === 'inventory'" />
        </div>

    </div>
</template>

<script>

import ScanOrders from '../../../components/ScanBarcode/ScanOrders';
import ScanInventory from '../../../components/ScanBarcode/ScanInventory';


export default {
    name: "ScanBarCodePage",
    components: {
      ScanOrders,
      ScanInventory
    },
    data() {
      return { 
        type: 'orders',
      }
    },
    methods: {
      changeType(type) {
        this.type = type;
      }
    }
};
</script>

<style lang="scss">

@import "../../../styles/styles.scss";

.scan-bar-code-page-main-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 15px 0px;
}

.mt-50{
  margin-top: 50px;
}

.basic-button {
  width: 100%;
  height: 60px;
  cursor: pointer;
  border: none;
  background: $BROWN-5;
}

.selected {
  background: $BROWN-10;
  color: $GREY-2;
  border: 2px solid $BROWN-12;
}

</style>
