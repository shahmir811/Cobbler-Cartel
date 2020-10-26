<template>
    <div class="admin-import-file-wrapping-div">
        <h1 class="admin-orders-managment-main-title">Orders Management</h1>

        <div class="display-orders-summary-div" v-if="orders && !loading">
            <div
                class="round-div-showing-order-status processing-status"
                @click.prevent="getOrderByStatus(null)"
            >
                <p>{{ orders.length }}</p>
                <p>Processing</p>
            </div>
            <div
                class="round-div-showing-order-status confirmed-status"
                @click.prevent="getOrderByStatus('confirmed')"
            >
                <p v-if="countOrdersByStatus.confirmed">
                    {{ countOrdersByStatus.confirmed.length }}
                </p>
                <p>Confirmed</p>
            </div>
            <div
                class="round-div-showing-order-status upper-status"
                @click.prevent="getOrderByStatus('upper')"
            >
                <p v-if="countOrdersByStatus.upper">
                    {{ countOrdersByStatus.upper.length }}
                </p>
                <p>Upper</p>
            </div>
            <div
                class="round-div-showing-order-status bottom-status"
                @click.prevent="getOrderByStatus('bottom')"
            >
                <p v-if="countOrdersByStatus.bottom">
                    {{ countOrdersByStatus.bottom.length }}
                </p>
                <p>Bottom</p>
            </div>
            <div
                class="round-div-showing-order-status dispatched-status"
                @click.prevent="getOrderByStatus('dispatched')"
            >
                <p v-if="countOrdersByStatus.dispatched">
                    {{ countOrdersByStatus.dispatched.length }}
                </p>
                <p>Dispatched</p>
            </div>
            <div
                class="round-div-showing-order-status returned-status"
                @click.prevent="getOrderByStatus('returned')"
            >
                <p v-if="countOrdersByStatus.returned">
                    {{ countOrdersByStatus.returned.length }}
                </p>
                <p>Stock</p>
            </div>
        </div>

        <b-row v-if="orders && !loading" class="admin-show-orders-table-div">
            <b-col cols="12">
                <table class="table table-header table-striped">
                    <thead class="admin-orders-table-header">
                        <tr>
                            <th scope="col">S. No</th>
                            <th scope="col">Order No.</th>
                            <th scope="col">Order Received</th>
                            <th scope="col">Days Left</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Operated By</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="filteredOrders.length > 0">
                        <tr
                            v-for="(order, index) in filteredOrders"
                            :key="order.id"
                        >
                            <td>{{ ++index }}</td>
                            <td>{{ order.order_no }}</td>
                            <td>{{ order.order_received_at }}</td>
                            <td>{{ order.days_left }}</td>
                            <td>{{ order.total }}</td>
                            <td>
                                <strong>{{ capitalize(order.status) }}</strong>
                            </td>
                            <td>{{ order.operated_by }}</td>
                            <td>
                                <button class="btn btn-success">View</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </b-col>
        </b-row>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: "Admin-ImportExcelFile",
    computed: {
        ...mapGetters({
            loading: "orders/loading",
            orders: "orders/orders",
            filteredOrders: "orders/filteredOrders",
            countOrdersByStatus: "orders/countOrdersByStatus"
        })
    },
    mounted() {
        this.getAllOrders();
    },
    data() {
        return {
            //
        };
    },
    methods: {
        ...mapActions({
            getAllOrders: "orders/getAllOrders",
            getOrderByStatus: "orders/getOrderByStatus"
        }),
        capitalize(order) {
            return order[0].toUpperCase() + order.slice(1);
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

.confirmed {
    // bgColor is a function defined in _functions.scss file
    color: bgColor("confirmed");
}

.finished {
    // bgColor is a function defined in _functions.scss file
    color: bgColor("finished");
}

.upper {
    // bgColor is a function defined in _functions.scss file
    color: bgColor("upper");
}

.bottom {
    // bgColor is a function defined in _functions.scss file
    color: bgColor("bottom");
}

.dispatched {
    // bgColor is a function defined in _functions.scss file
    color: bgColor("dispatched");
}

.returned {
    // bgColor is a function defined in _functions.scss file
    color: bgColor("returned");
}
</style>
