<template>
    <div class="completed-orders-page-wrapper-div">
        <h1 class="completed-orders-page-main-title">Completed Orders</h1>

        <FilterOrders :status="status" />

        <OrdersTable :status="status" />
        
    </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex';

import FilterOrders from "../../../components/Orders/FilterOrders";
import OrdersTable from "../../../components/Orders/OrdersTable";

export default {
    name: "CompleteOrders",
    mounted() {
        this.getAllCompletedOrders();
    }, 
    computed: {
        ...mapGetters({
            orders: "orders/orders",
            loading: "orders/loading"
        })
    },
    components: {
        FilterOrders,
        OrdersTable
    },
    data() {
        return {
            status: "finished"
        };
    },
    methods: {
        ...mapActions({
            getAllCompletedOrders: 'orders/getAllCompletedOrders',
        }),
    },
};
</script>

<style lang="scss">

@import '../../../styles/styles.scss';

.completed-orders-page-main-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 30px 0px;
    }

</style>
