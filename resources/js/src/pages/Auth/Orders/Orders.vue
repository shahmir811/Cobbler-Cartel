<template>
    <div class="admin-import-file-wrapping-div" v-if="orders && !loading">
        <h1 class="admin-orders-managment-main-title">Orders Management</h1>

        <OrdersSummary :filterOrdersMethod="filterOrders" />

        <FilterOrders :status="status" />

        <OrdersTable :status="status" />
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
import { mapGetters, mapActions } from "vuex";

import OrdersSummary from "../../../components/Orders/OrdersSummary";
import FilterOrders from "../../../components/Orders/FilterOrders";
import OrdersTable from "../../../components/Orders/OrdersTable";

export default {
    name: "OrdersManagement",
    mounted() {
        this.getAllOrders();
    },
    computed: {
        ...mapGetters({
            orders: "orders/orders",
            loading: "orders/loading"
        })
    },
    components: {
        OrdersSummary,
        FilterOrders,
        OrdersTable
    },
    data() {
        return {
            status: "processing"
        };
    },
    methods: {
        ...mapActions({
            getAllOrders: "orders/getAllOrders",
            getOrderByStatus: "orders/getOrderByStatus",
            noFilterRecord: "orders/noFilterRecord"
        }),
        filterOrders(status) {
            this.noFilterRecord();
            this.status = status ? status : "processing";
            this.getOrderByStatus(this.status);
        }
    }
};
</script>

<style lang="scss">
@import "../../../styles/styles.scss";

.admin-orders-managment-main-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 30px 0px;
}

.display-orders-summary-div {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.round-div-showing-order-status {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    cursor: pointer;
    @extend .regular-16px-24px;

    p {
        margin-bottom: 0px;
    }
}

.column-containing-filter-text {
    display: flex;
    flex-direction: row-reverse;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 30px;
}

.processing-status {
    background: $PROCESSING;

    &:hover {
        border: 5px solid darken($PROCESSING, 30%);
    }
}

.confirmed-status {
    background: $CONFIRMED;
    &:hover {
        border: 5px solid darken($CONFIRMED, 30%);
    }
}

.upper-status {
    background: $UPPER;
    &:hover {
        border: 5px solid darken($UPPER, 30%);
    }
}

.bottom-status {
    background: $BOTTOM;
    &:hover {
        border: 5px solid darken($BOTTOM, 30%);
    }
}

.dispatched-status {
    background: $DISPATCHED;
    &:hover {
        border: 5px solid darken($DISPATCHED, 30%);
    }
}

.returned-status {
    background: $RETURNED;
    &:hover {
        border: 5px solid darken($RETURNED, 30%);
    }
}

.daysLeft-0 {
    background: darken($RETURNED, 1%) !important;
}

.daysLeft-1 {
    background: lighten($RETURNED, 5%) !important;
}

.confirmed {
    // bgColor is a function defined in _functions.scss file
    background: bgColor("confirmed");
}

.processing {
    // bgColor is a function defined in _functions.scss file
    background: bgColor("processing");
}

.finished {
    // bgColor is a function defined in _functions.scss file
    background: bgColor("finished");
}

.upper {
    // bgColor is a function defined in _functions.scss file
    background: bgColor("upper");
}

.bottom {
    // bgColor is a function defined in _functions.scss file
    background: bgColor("bottom");
}

.dispatched {
    // bgColor is a function defined in _functions.scss file
    background: bgColor("dispatched");
}

.returned {
    // bgColor is a function defined in _functions.scss file
    background: bgColor("returned");
}
</style>
