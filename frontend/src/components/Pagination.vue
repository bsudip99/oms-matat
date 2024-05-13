<template>
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
      <!-- Previous page button -->
      <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
        <a class="page-link" href="#" @click.prevent="emitPageChange(currentPage - 1)">Previous</a>
      </li>
      <!-- Page buttons -->
      <li class="page-item" v-for="page in totalPages" :key="page" :class="{ 'active': page === currentPage }">
        <a class="page-link" href="#" @click.prevent="emitPageChange(page)">{{ page }}</a>
      </li>
      <!-- Next page button -->
      <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
        <a class="page-link" href="#" @click.prevent="emitPageChange(currentPage + 1)">Next</a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: 'PaginationControl',
  props: {
    total: {
      type: Number,
      required: true
    },
    currentPage: {
      type: Number,
      required: true
    },
    perPage: {
      type: Number,
      required: true
    }
  },
  computed: {
    totalPages() {
      return Math.ceil(this.total / this.perPage);
    }
  },
  methods: {
    emitPageChange(page) {
      this.$emit('pageChange', page);
    }
  }
};
</script>

<style>
/* Pagination styles */
</style>
