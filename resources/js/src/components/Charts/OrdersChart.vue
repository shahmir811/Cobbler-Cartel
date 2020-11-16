<script>
import axios from '../../store/BaseUrl';
import { Bar } from "vue-chartjs";
import { mapGetters } from 'vuex';
import _ from 'lodash';

const barChartOptions = {
  scales: {
    yAxes: [{
      ticks: {
        beginAtZero: true
      },
      gridLines: {
        display: false
      }
    }],
    xAxes: [ {
      gridLines: {
        display: true
      },
    }]
  }
};

export default {
  name: "OrdersChart",
  extends: Bar,
  computed: {
    ...mapGetters({
      user: 'auth/user',
    })
  },
  mounted() {
    this.getOrdersChartData().then(() => {
      this.renderChart(
        {
          labels: this.ordersLabel,
          datasets: [
            {
              label: "Orders",
              backgroundColor: ["#ff66b3", '#89ed78', '#66ffd9', '#ff6666', '#ffc266'],
              data: this.ordersData,
            },
          ],
        },
        this.barChartOptions
      );
    })

  },
  data() {
    return {
      loading: false,
      ordersData: [],
      ordersLabel: [],
      barChartOptions: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            },
            gridLines: {
              display: false
            }
          }],
          xAxes: [ {
            gridLines: {
              display: false
            },
          }]
        },
        responsive: true,
        maintainAspectRatio: false        
      }      
    }
  },
  methods: {
    getOrdersChartData() {

      return new Promise((resolve, reject) => {
        if(this.user) {
          this.loading = true;
          axios.get(`/${this.user.role}/orders-overview`).then(response => {
            const { names, counts, totalRecords } = this.getNamesAndCount(response.data.data.records);
            this.$emit('processingOrdersCount', totalRecords);
            this.ordersLabel = names;
            this.ordersData = counts;
            this.loading = false;
            resolve();
          })
          .catch(error => {
            console.log(error);
            this.loading = false;
            reject();
          })          
        }
      })

    },
    getNamesAndCount(records) {
      let names = [];
      let counts = [];
      let totalRecords = 0;
      records.map(record => {
        names.push(_.capitalize(record.name));
        counts.push(record.count);
        totalRecords += record.count;
      })

      return {
        names,
        counts,
        totalRecords
      }

    }
  }
};
</script>

<style lang="scss" scoped>
@import "../../styles/styles.scss";

</style>