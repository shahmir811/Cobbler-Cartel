<template>
    <div class="purchases-page-wrapping-div" v-if="!loading">
        <h1 class="purchases-page-main-title">Purchase Management</h1>

        <AddUpdatePurchase />

        <PurchasesTable />
    </div>
    <div v-else>
        <b-card>
        <b-skeleton animation="wave" width="85%"></b-skeleton>
        <b-skeleton animation="wave" width="55%"></b-skeleton>
        <b-skeleton animation="wave" width="70%"></b-skeleton>
        </b-card>    
    </div>
</template>

<script>

import { mapGetters, mapActions} from 'vuex';
import AddUpdatePurchase from '../../../components/Purchases/AddUpdatePurchase';
import PurchasesTable from '../../../components/Purchases/PurchasesTable';

export default {
    name: "Purchases",
    mounted() {
      this.getItemsList();
      this.getAllPurchases();
    },
    computed: {
      ...mapGetters({
        loading: 'purchases/loading',
        errors: 'purchases/errors',
      })
    },
    components: {
      AddUpdatePurchase,
      PurchasesTable
    },
    methods: {
      ...mapActions({
        getItemsList: 'items/getItemsList',
        getAllPurchases: 'purchases/getAllPurchases'
      })
    }
};
</script>

<style lang="scss">
@import "../../../styles/styles.scss";

.purchases-page-main-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 30px 0px;
}
</style>
