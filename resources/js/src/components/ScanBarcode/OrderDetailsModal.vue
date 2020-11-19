<template>
    <!-- Modal -->
    <b-modal
        v-model="showOrderDetailsModal"
        size="xl"
        content-class="order-details-modal"
        title="Order Details"
        @ok.prevent="closeModal"
        @close.prevent="closeModal"
        @keydown.esc="closeModal"
    >
        <div class="model-body" v-if="order">
            <div class="modal-content">
                <b-row class="modal-show-details-individual-wrapper">
                    <h4>Order:</h4>
                    <div class="order-details-div">
                        <b-col>
                            <p class="order-modal-label">Order &#35;</p>
                            <p>{{ order.order_no }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Order Received</p>
                            <p>{{ order.order_received_at }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Dispatch Date</p>
                            <p>{{ order.order_dispatch_date }}</p>
                        </b-col>
                    </div>
                </b-row>
                <b-row class="modal-show-details-individual-wrapper">
                    <h4>Billing Details:</h4>
                    <div class="order-details-div">
                        <b-col>
                            <p class="order-modal-label">Name</p>
                            <p>{{ order.billing_customer }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Company Name</p>
                            <p>{{ order.billing_company_name }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Zip Code</p>
                            <p>{{ order.billing_zip_code }}</p>
                        </b-col>
                    </div>
                    <div class="order-details-div">
                        <b-col>
                            <p class="order-modal-label">City</p>
                            <p>{{ order.billing_city }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Country</p>
                            <p>{{ order.billing_country }}</p>
                        </b-col>

                        <b-col>
                            <p class="order-modal-label">Address</p>
                            <p>{{ order.billing_address }}</p>
                        </b-col>
                    </div>
                </b-row>
                <b-row class="modal-show-details-individual-wrapper">
                    <h4>Delivery Address:</h4>
                    <div class="order-details-div">
                        <b-col>
                            <p class="order-modal-label">Name</p>
                            <p>{{ order.delivery_customer }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Company Name</p>
                            <p>{{ order.delivery_company_name }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Zip Code</p>
                            <p>{{ removeQuote(order.delivery_zip_code) }}</p>
                        </b-col>
                    </div>
                    <div class="order-details-div">
                        <b-col>
                            <p class="order-modal-label">City</p>
                            <p>{{ order.delivery_city }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Country</p>
                            <p>{{ order.delivery_country }}</p>
                        </b-col>

                        <b-col>
                            <p class="order-modal-label">Address</p>
                            <p>{{ order.delivery_address }}</p>
                        </b-col>
                    </div>
                </b-row>
                <b-row class="modal-show-details-individual-wrapper">
                    <h4>Buyer Details:</h4>
                    <div class="order-details-div">
                        <b-col>
                            <p class="order-modal-label">Phone</p>
                            <p>{{ order.buyer_phone }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Email</p>
                            <p>{{ order.buyer_email }}</p>
                        </b-col>
                        <b-col> </b-col>
                    </div>
                </b-row>
                <b-row class="modal-show-details-individual-wrapper">
                    <h4>Shipping Details:</h4>
                    <div class="order-details-div">
                        <b-col>
                            <p class="order-modal-label">Delivery Method</p>
                            <p>{{ order.delivery_method }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Shipping Address</p>
                            <p>{{ order.shipping_label }}</p>
                        </b-col>
                        <b-col> </b-col>
                    </div>
                </b-row>
                <b-row class="modal-show-details-individual-wrapper">
                    <h4>Item Details:</h4>
                    <div class="order-details-div">
                        <b-col>
                            <p class="order-modal-label">Item Name</p>
                            <p>{{ order.item_name }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Item Size</p>
                            <p>{{ order.item_variant }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Item Price</p>
                            <p>{{ order.item_price }}</p>
                        </b-col>
                    </div>
                    <div class="order-details-div">
                        <b-col>
                            <p class="order-modal-label">Item Weight</p>
                            <p>{{ order.item_weight }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Quantity</p>
                            <p>{{ order.quantity }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Total Price</p>
                            <p>{{ order.total }}</p>
                        </b-col>
                    </div>
                </b-row>
                <b-row class="modal-show-details-individual-wrapper">
                    <h4>Additional Info:</h4>
                    <div class="order-details-div">
                        <b-col>
                            <p class="order-modal-label">Notes To Seller</p>
                            <p>{{ order.notes_to_seller }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Additional Info</p>
                            <p>{{ order.additional_info }}</p>
                        </b-col>
                    </div>
                </b-row>
            </div>
        </div>
        <template #modal-footer>
            <div class="w-100">
                <b-button
                    class="float-right order-details-modal-close-button"
                    @click="closeModal"
                >
                    Close
                </b-button>
            </div>
        </template>
    </b-modal>
</template>

<script>

export default {
    name: "OrderDetailsModal",
    props: {
        order: { type: Object },
        showOrderDetailsModal: { type: Boolean },
        closeModal: { type: Function }
    },
    data() {
        return {
            // 
        };
    },
    methods: {
        removeQuote(comingString) {
            return comingString.replace(/['"]+/g, "");
        }
    }
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";

.order-details-modal {
    .modal-header {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding-left: 42%;
        text-decoration: underline;
        color: $BROWN-12 !important;

        .modal-title {
            font-size: 2.5rem !important;
            font-weight: 500 !important;
            line-height: 1.2 !important;
        }
    }
}

.order-details-modal-close-button {
    width: 117px;
    height: 45px;
    background: $BROWN-10 !important;
    @extend .semibold-16px-24px;
    color: $GREY-2 !important;

    &:hover {
        @extend .semibold-16px-24px;
        background: $GREY-2 !important;
        color: $BROWN-10 !important;
        outline: none;
        border: none;
    }
}

.modal-show-details-individual-wrapper {
    display: flex;
    flex-direction: column;
    padding-left: 30px;
    margin: 0px;
}

.order-details-div {
    display: flex;
    justify-content: space-between;
}

.order-modal-label {
    font-size: 20px;
    font-weight: bold;
    line-height: 24px;
}

.modal-content {
    border: none !important;
    /* overflow-y: auto; */
}
</style>
