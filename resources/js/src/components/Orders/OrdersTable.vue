<template>
    <div>
        <OrderDetailsModal
            :showOrderDetailsModal="showOrderDetailsModal"
            :closeModal="closeModal"
        />

        <div class="row mb-10">
            <div class="col-md-2 offset-md-10">
                <a 
                    href="#" 
                    class="btn btn-success" 
                    :class="anyOrderSelected ? '' : 'disabled'"
                    @click.prevent="downloadMultipleBarCodes"
                >
                    Download Barcodes
                </a>
            </div>
        </div>

        <b-row v-if="orders && !loading" class="admin-show-orders-table-div">
            <b-col cols="12">
                <table class="table table-header table-striped">
                    <thead
                        class="admin-orders-table-header"
                        :class="status ? status : 'processing'"
                    >
                        <tr>
                            <th v-if="url === 'orders'"></th>
                            <th scope="col">S. No</th>
                            <th scope="col">Order No.</th>
                            <th scope="col">Order Received</th>
                            <th scope="col" v-if="status !== 'finished'">Days Left</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Operated By</th>
                            <th scope="col" v-if="status !== 'finished'">
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
                            :class="showRedLine(order)"
                        >
                            <td v-if="url === 'orders'">
                                <input 
                                    type="checkbox" 
                                    id="order.order_no" 
                                    :value="order.order_no" 
                                    v-model="selectedOrders" 
                                />
                            </td>
                            <td>{{ ++index }}</td>
                            <td>{{ order.order_no }}</td>
                            <td>{{ order.order_received_at }}</td>
                            <td v-if="status !== 'finished'">{{ order.days_left }}</td>
                            <td>{{ order.total }}</td>
                            <td>
                                <strong>{{ capitalize(order.status) }}</strong>
                            </td>
                            <td>{{ order.operated_by }}</td>
                            <td v-if="status !== 'finished'">
                                <b-button
                                    variant="success"
                                    size="sm"
                                    @click.prevent="markAsCompleted(order.order_no)"
                                    >&#10004;</b-button
                                >
                            </td>
                            <td>
                                <a href="#" title="Generate BarCode" @click.prevent="generateAndDownloadBarCode(order.order_no)"
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
                                    v-if="order.tableName === 'orders'"
                                    ><i
                                        class="fa fa-pencil-square-o"
                                        aria-hidden="true"
                                    ></i
                                ></a>
                                <a
                                    v-if="role && role === 'admin'"
                                    href="#"
                                    title="Remove Order"
                                    @click.prevent="onDeleteHandler(order.order_no)"
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
import {generateAndDownloadBarcodeInPDF} from './generateBarcode';
import { getMultipleOrderNumbers } from './generateMultipleBarcodes';
import JsBarcode from "jsbarcode";

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
        }),
        anyOrderSelected() {
            return this.selectedOrders.length > 0 ? true : false;
        }
    },
    mounted() {
        // if(this.url === 'orders') {
        //     console.log("YES orders endpoint");
        //     this.filteredOrders;
        // }
    },
    components: {
        OrderDetailsModal
    },
    data() {
        return {
            showOrderDetailsModal: false,
            url: this.$route.name,
            selectedOrders: [],
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
            markOrderAsComplete: "orders/markOrderAsComplete",
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
        showRedLine(order) {
            // Don't show red on completed-orders route
            return this.$route.name === 'completed-orders' ? '' : `daysLeft-${order.days_left}`;
        },        
        updateOrderStatus(orderId) {
            this.selectOrder(orderId);
            this.$router.push({
                name: "change-order-status",
                params: { id: orderId }
            });
        },
        onDeleteHandler(order_no) {
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
                        this.removeOrder(order_no).then(() => {
                            this.$swal.fire(
                                "Deleted!",
                                "Order has been deleted.",
                                "success"
                            );
                        });
                    }
                });
        },
        markAsCompleted(orderNo) {
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
                        this.markOrderAsComplete(orderNo).then(() => {
                            this.$swal.fire(
                                "Completed!",
                                "Order has been marked as completed.",
                                "success"
                            );
                        });
                    }
                });
        },
        generateAndDownloadBarCode(orderNo) {
            generateAndDownloadBarcodeInPDF(orderNo);
        },
        downloadMultipleBarCodes() {
            getMultipleOrderNumbers(this.selectedOrders);
        }
    }
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";
</style>
