import { defineStore } from "pinia";
import { ref } from "vue";
import axiosInstance from "../lib/axios";
const useOrder = defineStore('order', () => {
  const orders = ref(null);
  const error = ref(null);
  const loading = ref(false);

  const fetchOrder = async () => {
    const localToken = localStorage.getItem("token");
    if (localToken) {
      try {
        loading.value = true;
        const { data } = await axiosInstance.get('admin/order/list');
        orders.value = data.data;
        error.value = null; // Clear any previous errors
      } catch (err) {
        error.value = "Failed to fetch orders";
        console.error("API Error:", err);
      } finally {
        loading.value = false;
      }
    } else {
      error.value = "No token found";
    }
  };

  const showOrder = async (orderId) => {
    const localToken = localStorage.getItem("token");
    if (localToken) {
      try {
        loading.value = true;
        const { data } = await axiosInstance.get('admin/order/single/' + orderId);
        orders.value = data.data;
        error.value = null; // Clear any previous errors
      } catch (err) {
        error.value = "Failed to fetch order";
        console.error("API Error:", err);
      } finally {
        loading.value = false;
      }
    } else {
      error.value = "No token found";
    }
  };

  // Create a new order
  const createOrder = async (neworder) => {
    try {
      loading.value = true;
      const { data } = await axiosInstance.post('admin/user/order/store', neworder);
      error.value = null;
    } catch (err) {
      error.value = err.response.data.message;
      console.error("API Error:", err);
    } finally {
      loading.value = false;
    }
  };

  // Update an existing order
  const updateOrder = async (id, updatedorder) => {
    try {
      loading.value = true;
      const { data } = await axiosInstance.post(`admin/order/update/${id}`, updatedorder);
      error.value = null;
    } catch (err) {
      error.value = err.response.data.message;
      console.error("API Error:", err);
    } finally {
      loading.value = false;
    }
  };

  // Update an existing order
  const updateStatus = async (id, payload) => {
    try {
      loading.value = true;
      const { data } = await axiosInstance.post(`admin/order/change/status/${id}`, payload);
      error.value = null;
    } catch (err) {
      error.value = err.response.data.message;
      console.error("API Error:", err);
    } finally {
      loading.value = false;
    }
  };

  // Delete a order
  const deleteOrder = async (id) => {
    try {
      loading.value = true;
      await axiosInstance.post(`admin/order/destroy/${id}`);
      orders.value = orders.value.filter((order) => order.id !== id); // Remove the deleted order from the list
      error.value = null;
    } catch (err) {
      error.value = "Failed to delete order";
      console.error("API Error:", err);
    } finally {
      loading.value = false;
    }
  };

  return {
    orders,
    error,
    loading,
    updateStatus,
    fetchOrder,
    showOrder,
    createOrder,
    updateOrder,
    deleteOrder,
  };
});

export default useOrder;
