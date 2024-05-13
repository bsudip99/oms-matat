<!-- SyncButton.vue -->
<template>
  <button @click="sync">Sync Orders</button>
</template>

<script>
import apiService from '@/services/apiService';
export default {
  methods: {
    async sync() {
      try {
        await apiService.syncOrders();
        this.$emit('sync');
      } catch (error) {
        console.error('Error syncing orders:', error);
      }
    },
  },
};
</script>
