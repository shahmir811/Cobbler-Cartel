<template>
    <div class="home-page-wrapper-div">
        <h1 class="home-page-main-title">Overview</h1>

        <div class="row">
            <div class="col-md-6 orders-chart-div">
                <OrdersChart @processingOrdersCount="ordersCount = $event" />

                <h4>Total Processing orders: {{ ordersCount }}</h4>
            </div>

            <div class="col-md-6 orders-chart-div">
                <InventoyChart />
            </div>            
        </div>

    </div>
</template>

<script>

import OrdersChart from '../../../components/Charts/OrdersChart';
import InventoyChart from '../../../components/Charts/InventoryChart';

export default {
    name: "Home",
    components: {
        OrdersChart,
        InventoyChart
    },
    data() {
        return {
            ordersCount: 0,
        }
    }
};
</script>

<style lang="scss" scoped>

@import "../../../styles/styles.scss";

.home-page-main-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 30px 0px;
}
</style>
