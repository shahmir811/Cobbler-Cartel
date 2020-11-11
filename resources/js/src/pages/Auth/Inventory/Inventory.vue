<template>
    <div class="inventory-management-wrapping-div" v-if='!loading'>
        <h1 class="inventory-management-main-title">Inventory Managment</h1>

        <AddUpdateInventoryItem />

        <InventoryItemsTable />
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
import AddUpdateInventoryItem from '../../../components/Inventory/AddUpdateInventoryItem';
import InventoryItemsTable from '../../../components/Inventory/InventoryItemsTable';

export default {
    name: "InventoryManagement",
    computed: {
        ...mapGetters({
            loading: 'inventory/loading',
        })
    },
    components: {
        AddUpdateInventoryItem,
        InventoryItemsTable
    },
    mounted() {
        this.getItemsList();
        this.getInventoryItemsList();
    },
    methods: {
        ...mapActions({
            getItemsList: 'items/getItemsList',
            getInventoryItemsList: 'inventory/getInventoryItemsList',
        }),
    },
};
</script>

<style lang="scss">
@import "../../../styles/styles.scss";

.inventory-management-main-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 30px 0px;  
}

</style>
