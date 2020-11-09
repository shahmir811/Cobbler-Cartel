<template>
    <div class="items-management-wrapping-div" v-if="!loading">
        <h1 class="items-management-main-title">Items Managment</h1>

        <AddItem />

        <ItemsTable />

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

import AddItem from '../../../components/Item/AddItem';
import ItemsTable from '../../../components/Item/ItemsTable';

import { mapGetters, mapActions } from 'vuex';

export default {
    name: "ItemsManagement",
    data() {
        return { 
            showAddItem: false,
        }
    },
    computed: {
        ...mapGetters({
            loading: 'items/loading',
        })
    },
    mounted() {
        this.getItemsList();
    },
    components: {
        AddItem,
        ItemsTable
    }, 
    methods: {
        ...mapActions({
            getItemsList: 'items/getItemsList'
        }),
    },
};
</script>

<style lang="scss">

@import "../../../styles/styles.scss";

.items-management-main-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 30px 0px;
}

</style>
