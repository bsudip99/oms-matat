<template>
  <div class="order-filter">
    <div class="status-filter">
      <label for="status">Status:</label>
      <select
        id="status"
        class="form-control"
        v-model="selectedStatus"
        @change="filterByStatus"
      >
        <option value="">All</option>
        <option v-for="status in statuses" :key="status" :value="status">
          {{ status }}
        </option>
      </select>
    </div>
    <div class="date-filter">
      <label for="startDate">Start Date:</label>
      <input
        type="date"
        id="startDate"
        class="form-control"
        v-model="startDate"
        @change="filterByDate"
      />
      <label for="endDate">End Date:</label>
      <input
        type="date"
        id="endDate"
        class="form-control"
        v-model="endDate"
        @change="filterByDate"
      />
    </div>
    <button @click="resetFilters">Reset Filters</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedStatus: '',
      startDate: '',
      endDate: '',
      statuses: ['processing', 'completed', 'cancelled'] // Example status options
    };
  },
  methods: {
    filterByStatus() {
      this.$emit("filter-change", {
        status: this.selectedStatus,
        startDate: this.startDate,
        endDate: this.endDate
      });
    },
    filterByDate() {
      this.$emit("filter-change", {
        status: this.selectedStatus,
        startDate: this.startDate,
        endDate: this.endDate
      });
    },
    resetFilters() {
      this.selectedStatus = '';
      this.startDate = '';
      this.endDate = '';
      this.filterByStatus(); // Emit filter change event to trigger filter reset in parent component
    }
  },
};
</script>

<style scoped>
.order-filter {
  margin-bottom: 20px;
}

.order-filter label {
  font-weight: bold;
  margin-right: 10px;
  font-size: 14px; /* Adjust font size */
}

.order-filter select,
.order-filter input[type="date"] {
  padding: 3px 5px; /* Adjust padding */
  border-radius: 3px; /* Adjust border radius */
  border: 1px solid #ccc;
  outline: none;
  font-size: 14px; /* Adjust font size */
  margin-right: 10px;
}

.order-filter select:focus,
.order-filter input[type="date"]:focus {
  border-color: #007bff;
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}
</style>
