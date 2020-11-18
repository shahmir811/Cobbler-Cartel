<template>
    <div class="change-order-status-page-wrapping-div">
        <h1 class="change-order-status-page-main-title">
            Change Order Status
        </h1>

        <b-row v-if="order">
            <b-col md="6" offset-md="2">
                <b-row>
                    <b-col><p class="order-label">Current Status:</p> </b-col>
                    <b-col class="pt-6 style-right-side-col"
                        ><p>Confirmed</p></b-col
                    >
                </b-row>
                <b-row>
                    <b-col>
                        <p class="order-label">Change Status To:</p>
                    </b-col>
                    <b-col class="pt-6 display-all-statuses-div">
                        <div v-for="status in allStatuses" :key="status.id">
                            <input
                                v-model="selectedStatus"
                                type="radio"
                                name="status.name"
                                :id="status.name"
                                :value="status.name"
                            />
                            <label :for="status.name">{{
                                capitalize(status.name)
                            }}</label>
                        </div>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col></b-col>
                    <b-col class="wrapper-div-for-buttons">
                        <button
                            class="btn btn-success"
                            :disabled="loading"
                            @click.prevent="onChangeAndUpdateOrderStatus"
                        >
                            <template v-if="!loading">
                                Update
                            </template>
                            <template v-else>
                                <div
                                    class="spinner-border text-dark"
                                    role="status"
                                >
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </template>
                        </button>
                        <router-link
                            to="/orders"
                            class="btn btn-danger"
                            :disabled="loading"
                            tag="button"
                            >Cancel</router-link
                        >
                    </b-col>
                </b-row>
            </b-col>
        </b-row>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: "ChangeOrderStatus",
    computed: {
        ...mapGetters({
            loading: "orders/loading",
            order: "orders/selectOrderToUpdateStatus",
            orders: 'orders/orders',
        })
    },
    mounted() {
        if(this.orders.length > 0) {
            this.selectedStatus = this.order.status;
            this.orderNo = this.order.order_no;
        } else {
            let id = this.$route.params.id;
            this.getAllOrdersFromChangeOrderStatusPage(id)
            .then(() => {
                this.selectedStatus = this.order.status;
                this.orderNo = this.order.order_no;                
            })
        }
    },
    data() {
        return {
            currentStatus: "confirmed",
            selectedStatus: null,
            orderNo: null,
            allStatuses: [
                {
                    id: 1,
                    name: "confirmed"
                },
                {
                    id: 2,
                    name: "upper"
                },
                { id: 3, name: "bottom" },
                { id: 4, name: "finished" },
                { id: 5, name: "dispatched" },
                { id: 6, name: "returned" }
            ]
        };
    },
    methods: {
        ...mapActions({
            updateOrderStatus: "orders/updateOrderStatus",
            getAllOrdersFromChangeOrderStatusPage: 'orders/getAllOrdersFromChangeOrderStatusPage',
        }),
        onChangeAndUpdateOrderStatus() {
            let data = {
                id: this.$route.params.id,
                statusName: this.selectedStatus,
                orderNo: this.orderNo,
            };
            this.$swal
                .fire({
                    title: "Are you sure to change this order status?",
                    // text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, change it!"
                })
                .then(result => {
                    if (result.value) {
                        this.updateOrderStatus(data).then(() => {
                            this.$swal.fire(
                                "Completed!",
                                "Order status has been changed.",
                                "success"
                            );
                        });
                    }
                });
        },
        capitalize(order) {
            return order[0].toUpperCase() + order.slice(1);
        }
    }
};
</script>

<style lang="scss">
@import "../../../styles/styles.scss";

.change-order-status-page-main-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 30px 0px 50px;
}

.order-label {
    font-size: 24px;
    font-weight: bold;
    line-height: 32px;
}

.pt-6 {
    padding-top: 6px !important;
}

.style-right-side-col {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.display-all-statuses-div {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    /* padding-left: 320px; */
}

.wrapper-div-for-buttons {
    display: flex;
    /* flex-direction: column; */
    justify-content: flex-start;
    align-items: flex-start;

    button {
        margin-right: 10px;
    }
}
</style>
