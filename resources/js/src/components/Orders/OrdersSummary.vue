<template>
    <div class="display-orders-summary-div" v-if="orders && !loading">
        <div
            class="round-div-showing-order-status processing-status"
            @click.prevent="filterOrdersMethod(null)"
        >
            <p>{{ orders.length }}</p>
            <p>Processing</p>
        </div>
        <div
            class="round-div-showing-order-status confirmed-status"
            @click.prevent="filterOrdersMethod('confirmed')"
        >
            <p v-if="countOrdersByStatus.confirmed">
                {{ countOrdersByStatus.confirmed.length }}
            </p>
            <p v-else>0</p>
            <p>Confirmed</p>
        </div>
        <div
            class="round-div-showing-order-status upper-status"
            @click.prevent="filterOrdersMethod('upper')"
        >
            <p v-if="countOrdersByStatus.upper">
                {{ countOrdersByStatus.upper.length }}
            </p>
            <p v-else>0</p>
            <p>Upper</p>
        </div>
        <div
            class="round-div-showing-order-status bottom-status"
            @click.prevent="filterOrdersMethod('bottom')"
        >
            <p v-if="countOrdersByStatus.bottom">
                {{ countOrdersByStatus.bottom.length }}
            </p>
            <p v-else>0</p>
            <p>Bottom</p>
        </div>
        <div
            class="round-div-showing-order-status dispatched-status"
            @click.prevent="filterOrdersMethod('dispatched')"
        >
            <p v-if="countOrdersByStatus.dispatched">
                {{ countOrdersByStatus.dispatched.length }}
            </p>
            <p v-else>0</p>
            <p>Dispatched</p>
        </div>
        <div
            class="round-div-showing-order-status returned-status"
            @click.prevent="filterOrdersMethod('returned')"
        >
            <p v-if="countOrdersByStatus.returned">
                {{ countOrdersByStatus.returned.length }}
            </p>
            <p v-else>0</p>
            <p>Stock</p>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: "OrdersSummary-component",
    props: {
        filterOrdersMethod: { type: Function }
    },
    computed: {
        ...mapGetters({
            loading: "orders/loading",
            orders: "orders/orders",
            countOrdersByStatus: "orders/countOrdersByStatus"
        })
    },
    methods: {
        ...mapActions({})
    }
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";

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
</style>
