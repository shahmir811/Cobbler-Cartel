<template>
    <div class="daily-expense-wrapping-div" v-if="!loading">
        <h1 class="daily-expense-main-title">Daily Expenses Log</h1>

        <AddDailyExpense />

        <DailyExpenseTable />

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

import { mapGetters, mapActions} from 'vuex';
import AddDailyExpense from '../../../components/DailyExpense/AddDailyExpense';
import DailyExpenseTable from '../../../components/DailyExpense/DailyExpenseTable';

export default {
    name: "DailyExpense",
    computed: {
      ...mapGetters({
        loading: 'expenses/loading'
      })
    },
    mounted() {
      this.getAllExpenses();
    },
    components: {
      AddDailyExpense,
      DailyExpenseTable
    },
    methods: {
      ...mapActions({
        getAllExpenses: 'expenses/getAllExpenses',
      })
    },
};
</script>

<style lang="scss">
@import "../../../styles/styles.scss";

.daily-expense-main-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 30px 0px;
}

</style>
