<template>
  <div class="search-container">
    <input
      type="text"
      v-model="searchTerm"
      placeholder="Search..."
      @input="search"
    />
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchTerm: ''
    };
  },
  methods: {
    search() {
      // Perform search and emit results to parent
      const searchResults = this.searchTerm;
      this.$emit('search-change', searchResults);
    },
    filterOrders() {
      // Perform filtering logic here based on searchTerm
      // For now, returning an empty array as a placeholder
      return [];
    }
  }
};
</script>

<style scoped>
.search-container {
  margin-bottom: 20px;
}

.search-container input {
  padding: 5px;
  width: 100%;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 14px;
}
</style>
