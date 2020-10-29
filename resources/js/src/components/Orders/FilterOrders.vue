<template>
    <div v-if="orders && !loading">
        <b-row v-if="status === 'processing'">
            <b-col class="column-containing-filter-text">
                <div>
                    <b-form-input
                        type="number"
                        v-model="searchText"
                        placeholder="Order #"
                        @keyup="searchOrder"
                    ></b-form-input>
                </div>
            </b-col>
        </b-row>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: "FilterOrders-component",
    props: {
        status: { type: String }
    },
    computed: {
        ...mapGetters({
            loading: "orders/loading",
            orders: "orders/orders"
        })
    },
    data() {
        return {
            searchText: ""
        };
    },
    methods: {
        ...mapActions({
            getOrderByOrderNo: "orders/getOrderByOrderNo"
        }),
        searchOrder() {
            if (this.searchText !== "") {
                this.getOrderByOrderNo(this.searchText);
            }
        }
    }
};
</script>

<style lang="scss">
@import "../../styles/styles.scss";

.column-containing-filter-text {
    display: flex;
    flex-direction: row-reverse;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 30px;
}
</style>
