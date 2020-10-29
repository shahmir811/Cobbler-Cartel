<template>
    <div>
        <OrderDetailsModal
            :showOrderDetailsModal="showOrderDetailsModal"
            :closeModal="closeModal"
        />

        <b-row v-if="orders && !loading" class="admin-show-orders-table-div">
            <b-col cols="12">
                <table class="table table-header table-striped">
                    <thead
                        class="admin-orders-table-header"
                        :class="status ? status : 'processing'"
                    >
                        <tr>
                            <th scope="col">S. No</th>
                            <th scope="col">Order No.</th>
                            <th scope="col">Order Received</th>
                            <th scope="col">Days Left</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Operated By</th>
                            <th scope="col">
                                <span>Mark as</span>
                                <span>completed</span>
                            </th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="filteredOrders.length > 0">
                        <tr
                            v-for="(order, index) in filteredOrders"
                            :key="order.id"
                            :class="`daysLeft-${order.days_left}`"
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
                                <b-button
                                    variant="success"
                                    size="sm"
                                    @click.prevent="markAsCompleted(order.id)"
                                    >&#10004;</b-button
                                >
                            </td>
                            <td>
                                <a href="#" title="Generate BarCode"
                                    ><i
                                        class="fa fa-barcode"
                                        aria-hidden="true"
                                    ></i
                                ></a>
                                <a
                                    href="#"
                                    title="View Order Details"
                                    @click.prevent="viewOrder(order.id)"
                                    ><i class="fa fa-eye" aria-hidden="true"></i
                                ></a>
                                <a
                                    href="#"
                                    title="Edit Order Status"
                                    @click.prevent="updateOrderStatus(order.id)"
                                    ><i
                                        class="fa fa-pencil-square-o"
                                        aria-hidden="true"
                                    ></i
                                ></a>
                                <a
                                    v-if="role === 'admin'"
                                    href="#"
                                    title="Remove Order"
                                    @click.prevent="onDeleteHandler(order.id)"
                                    ><i
                                        class="fa fa-trash-o"
                                        aria-hidden="true"
                                    ></i
                                ></a>
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

import OrderDetailsModal from "./OrderDetailsModal";

export default {
    name: "OrdersTable-component",
    props: {
        status: { type: String }
    },
    computed: {
        ...mapGetters({
            loading: "orders/loading",
            orders: "orders/orders",
            filteredOrders: "orders/filteredOrders",
            countOrdersByStatus: "orders/countOrdersByStatus",
            role: "auth/role"
        })
    },
    components: {
        OrderDetailsModal
    },
    data() {
        return {
            showOrderDetailsModal: false
        };
    },
    methods: {
        ...mapActions({
            getAllOrders: "orders/getAllOrders",
            getOrderByStatus: "orders/getOrderByStatus",
            getOrderByOrderNo: "orders/getOrderByOrderNo",
            noFilterRecord: "orders/noFilterRecord",
            removeOrder: "orders/removeOrder",
            getOrderDetails: "orders/getOrderDetails",
            completeOrder: "orders/completeOrder",
            selectOrder: "orders/selectOrder"
        }),
        capitalize(order) {
            return order[0].toUpperCase() + order.slice(1);
        },
        closeModal() {
            this.showOrderDetailsModal = false;
        },
        viewOrder(id) {
            this.getOrderDetails(id);
            this.showOrderDetailsModal = true;
        },
        updateOrderStatus(orderId) {
            this.selectOrder(orderId);
            this.$router.push({
                name: "change-order-status",
                params: { id: orderId }
            });
        },
        onDeleteHandler(orderId) {
            this.$swal
                .fire({
                    title: "Are you sure to delete this order?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                })
                .then(result => {
                    if (result.value) {
                        this.removeOrder(orderId).then(() => {
                            this.$swal.fire(
                                "Deleted!",
                                "Order has been deleted.",
                                "success"
                            );
                        });
                    }
                });
        },
        markAsCompleted(orderId) {
            this.$swal
                .fire({
                    title: "Are you sure to mark this order as complete?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, do it!"
                })
                .then(result => {
                    if (result.value) {
                        this.completeOrder(orderId).then(() => {
                            this.$swal.fire(
                                "Completed!",
                                "Order has been marked as completed.",
                                "success"
                            );
                        });
                    }
                });
        }
    }
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";
</style>
