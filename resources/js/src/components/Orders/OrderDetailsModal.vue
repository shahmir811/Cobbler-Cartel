<template>
    <!-- Modal -->
    <b-modal
        scrollable
        v-model="showOrderDetailsModal"
        size="xl"
        content-class="order-details-modal"
        title="Order Details"
        @ok.prevent="closeModal"
        @close.prevent="closeModal"
    >
        <b-container v-if="order">
            <div class="modal-content">
                <b-row class="modal-show-details-individual-wrapper">
                    <h3>Order:</h3>
                    <div class="order-details-div">
                        <b-col>
                            <p class="order-modal-label">Order &#35;</p>
                            <p>{{ order.order_no }}</p>
                        </b-col>
                        <b-col>
                            <p class="order-modal-label">Order Received</p>
                            <p>{{ order.order_received_at }}</p>
                        </b-col>
                    </div>
                </b-row>
                <b-row class="modal-show-details-individual-wrapper">
                    <h3>Billing Details:</h3>
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
                            <p class="order-modal-label">Address</p>
                            <p>{{ order.billing_address }}</p>
                        </b-col>
                    </div>
                </b-row>
            </div>
        </b-container>
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
import { mapGetters } from "vuex";

export default {
    name: "OrderDetailsModal",
    props: {
        showOrderDetailsModal: { type: Boolean },
        closeModal: { type: Function }
    },
    computed: {
        ...mapGetters({
            order: "orders/viewOrderDetails"
        })
    },
    data() {
        return {
            //
        };
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
    margin: 10px 0px;
}

.order-details-div {
    display: flex;
    justify-content: space-between;
}
</style>
