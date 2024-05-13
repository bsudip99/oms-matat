<template>
  <div class="order-table-container">
    <h1 class="page-title">Order Table</h1>
    <div class="action-buttons">
      <SyncButton @sync="syncOrders" />
      <SearchComponent @search-change="handleSearch" />
      <FilterComponent @filter-change="applyFilters" />
    </div>

  <div class="table-container">
    <table class="table table-striped">
       <thead class="thead-dark">
         <tr>
           <th @click="sortBy('id')">Id {{ renderArrow('id') }}</th>
           <th @click="sortBy('number')">Order Number {{ renderArrow('number') }}</th>
           <th @click="sortBy('order_key')">Order Key {{ renderArrow('order_key') }}</th>
           <th @click="sortBy('status')">Status {{ renderArrow('status') }}</th>
           <th @click="sortBy('total')">Total {{ renderArrow('total') }}</th>
           <th @click="sortBy('date_created')">Date Created {{ renderArrow('date_created') }}</th>
           <th @click="sortBy('customer_id')">Customer Id {{ renderArrow('customer_id') }}</th>
           <th @click="sortBy('customer_note')">Customer Note {{ renderArrow('customer_note') }}</th>
           <th>Billing Name</th>
           <th>Shipping Name</th>
           <th>Line Items</th>
         </tr>
       </thead>
       <tbody>
         <tr v-for="order in orders" :key="order.id">
           <td>{{ order.id }}</td>
           <td>{{ order.number }}</td>
           <td>{{ order.order_key }}</td>
           <td>{{ order.status }}</td>
           <td>{{ order.total }}</td>
           <td>{{ formatDate(order.date_created) }}</td>
           <td>{{ order.customer_id }}</td>
           <td>{{ order.customer_note || 'N/A' }}</td>
           <td>{{ order.billing.first_name }} {{ order.billing.last_name }}</td>
           <td>{{ order.shipping.first_name }} {{ order.shipping.last_name }}</td>
           <td>
             <ul>
               <li v-for="lineItem in order.line_items" :key="lineItem.id">
                 {{ lineItem.name }} - Quantity: {{ lineItem.quantity }} - Price: {{ lineItem.price }}
               </li>
             </ul>
           </td>
         </tr>
       </tbody>
     </table>
  </div> 
    <!-- Pagination component -->
    <Pagination :total="totalOrders" :currentPage="currentPage" :perPage="perPage" @pageChange="fetchOrders" />

  </div>
</template>

<script>
import Pagination from './Pagination.vue';
import SyncButton from './SyncButton.vue';
import FilterComponent from './FilterComponent.vue';
import SearchComponent from './SearchComponent.vue';
import apiService from '@/services/apiService';

export default {
  components: {
    Pagination,
    SyncButton,
    FilterComponent,
    SearchComponent
  },
  data() {
    return {
      orders: [],
      totalOrders: 0,
      currentPage: 1,
      perPage: 10,
      statusFilter: '', // Initialize status filter
      startDateFilter: '', // Initialize start date filter
      endDateFilter: '', // Initialize end date filter
      sortByField: 'id', // Initialize sortBy field
      sortDirection: 'asc', // Initialize sort direction
      searchParam: '',
    };
  },
  async created() {
    await this.fetchOrders();
  },
  methods: {
    async fetchOrders(page = 1) {
      try {
        const params = {
          page,
          per_page: this.perPage,
          status: this.statusFilter,
          startDate: this.startDateFilter,
          endDate: this.endDateFilter,
          sortBy: this.sortByField,
          sortDirection: this.sortDirection,
          search: this.searchParam,
        };
        const { data, meta } = await apiService.fetchOrders(params);

        this.orders = data;
        this.totalOrders = meta.total;
        this.currentPage = page; // Update current page
      } catch (error) {
        console.error('Error fetching orders:', error);
      }
    },
    async syncOrders() {
      await this.fetchOrders();
    },
    async applyFilters({ status, startDate, endDate }) {
      this.statusFilter = status;
      this.startDateFilter = startDate;
      this.endDateFilter = endDate;
      await this.fetchOrders();
    },
    async handleSearch(searchQuery) {
      this.searchParam = searchQuery;
      await this.fetchOrders();
    },
    formatDate(dateString) {
      // Implement date formatting logic here
      return new Date(dateString).toLocaleDateString();
    },
    sortBy(field) {
      if (this.sortByField === field) {
        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortByField = field;
        this.sortDirection = 'asc';
      }
      // Fetch orders with new sorting parameters
      this.fetchOrders();
    },
    renderArrow(field) {
      if (this.sortByField === field) {
        return this.sortDirection === "asc" ? "▲" : "▼";
      }
      return "";
    },
  },
};
</script>

<style scoped>
.order-table-container {
  margin: 20px;
}

.page-title {
  font-size: 24px;
  margin-bottom: 20px;
}

.action-buttons {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
}

.table-container {
  overflow-x: auto;
}

.table {
  width: 100%;
  border-collapse: collapse;
}

.table th,
.table td {
  padding: 10px;
  text-align: left;
}

.table th {
  background-color: #f2f2f2;
}

.table tbody tr:nth-child(even) {
  background-color: #f2f2f2;
}

.table tbody tr:hover {
  background-color: #ddd;
}

.pagination {
  margin-top: 20px;
  display: flex;
  justify-content: center;
}

.pagination button {
  margin: 0 5px;
  padding: 5px 10px;
  border: 1px solid #ccc;
  background-color: #fff;
  cursor: pointer;
}

.pagination button.active {
  background-color: #007bff;
  color: #fff;
}
</style>