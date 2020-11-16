<script>
import axios from '../../store/BaseUrl';
import { Bar } from "vue-chartjs";
import { mapGetters } from 'vuex';
import _ from 'lodash';

export default {
  name: "InventoryChart",
  extends: Bar,
  computed: {
    ...mapGetters({
      user: 'auth/user',
    })
  },
  mounted() {
    this.getInventoryChartData().then(() => {
    this.renderChart(
      {
        labels: this.inventoryLabel,
        datasets: [
          {
            label: "Inventory",
            backgroundColor: "#f87979",
            data: this.inventoryData,
          }
        ]
      },
      this.barChartOptions
    );
    })

  },
  data() {
    return { 
      loading: false,
      inventoryData: [],
      inventoryLabel: [],
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
    getInventoryChartData () {
      
      return new Promise((resolve, reject) => {
        if(this.user) {
          this.loading = true;
          axios.get(`/${this.user.role}/inventory-overview`).then(response => {
            const { names, counts } = this.getNamesAndCount(response.data.data.records);
            this.inventoryLabel = names;
            this.inventoryData = counts;
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

      records.map(record => {
        names.push(_.capitalize(record.name));
        counts.push(record.count);
      })

      return {
        names,
        counts
      }

    }    
  }
};
</script>