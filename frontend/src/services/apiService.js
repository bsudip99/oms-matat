// apiService.js

import axios from 'axios';
import { useToast } from 'vue-toast-notification';

const apiClient = axios.create({
  baseURL: 'http://localhost:8000/api/v1',
});

const $toast = useToast();

export default {
  async fetchOrders(params) {
    try {
      const response = await apiClient.get('/orders', { params });
      return response.data;

    } catch (error) {
      throw new Error('Error fetching orders');
    }
  },

  async syncOrders() {
    try {
      const response =  await apiClient.get('/orders/syncOrder');
      if (response.data.success === true) {
        $toast.success(response.data.message);
      }
    } catch (error) {
      throw new Error('Error syncing orders');
    }
  },
};
