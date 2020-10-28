<template>
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
                            <a href="#" title="Generate BarCode"
                                ><i class="fa fa-barcode" aria-hidden="true"></i
                            ></a>
                            <a href="#" title="View Order Details"
                                ><i class="fa fa-eye" aria-hidden="true"></i
                            ></a>
                            <a href="#" title="Edit Order Status"
                                ><i
                                    class="fa fa-pencil-square-o"
                                    aria-hidden="true"
                                ></i
                            ></a>
                            <a
                                v-if="user.role === 'admin'"
                                href="#"
                                title="Remove Order"
                                @click.prevent="onDeleteHandler(order.id)"
                                ><i class="fa fa-trash-o" aria-hidden="true"></i
                            ></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </b-col>
    </b-row>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

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
            user: "auth/user"
        })
    },
    methods: {
        ...mapActions({
            getAllOrders: "orders/getAllOrders",
            getOrderByStatus: "orders/getOrderByStatus",
            getOrderByOrderNo: "orders/getOrderByOrderNo",
            noFilterRecord: "orders/noFilterRecord",
            removeOrder: "orders/removeOrder"
        }),
        capitalize(order) {
            return order[0].toUpperCase() + order.slice(1);
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
        }
    }
};
</script>

<style lang="scss"></style>
