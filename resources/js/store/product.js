import { defineStore } from "pinia";
import { ref } from "vue";
import axiosInstance from "../lib/axios";
const useProduct = defineStore('product', () => {
  const products = ref(null); // To store product list
  const error = ref(null); // To track errors
  const loading = ref(false); // To track loading state for API requests

  // Fetching product details if token is found in localstorage
  const fetchProduct = async () => {
    const localToken = localStorage.getItem("token");
    if (localToken) {
      try {
        loading.value = true;
        const { data } = await axiosInstance.get('admin/product/list');
        products.value = data.data;
        error.value = null; // Clear any previous errors
      } catch (err) {
        error.value = "Failed to fetch products";
        console.error("API Error:", err);
      } finally {
        loading.value = false;
      }
    } else {
      error.value = "No token found";
    }
  };

  // Fetching product details if token is found in localstorage
  const fetchPublicProduct = async () => {
    try {
      loading.value = true;
      const { data } = await axiosInstance.get('user/product/list');
      products.value = data.data;
      error.value = null; // Clear any previous errors
    } catch (err) {
      error.value = "Failed to fetch products";
      console.error("API Error:", err);
    } finally {
      loading.value = false;
    }
  };

  // Fetching product detail if token is found in localstorage
  const showProduct = async (productId) => {
    const localToken = localStorage.getItem("token");
    if (localToken) {
      try {
        loading.value = true;
        const { data } = await axiosInstance.get('admin/product/single/' + productId);
        products.value = data.data;
        error.value = null; // Clear any previous errors
      } catch (err) {
        error.value = "Failed to fetch product";
        console.error("API Error:", err);
      } finally {
        loading.value = false;
      }
    } else {
      error.value = "No token found";
    }
  };

  // Create a new product
  const createProduct = async (newProduct) => {
    try {
      loading.value = true;
      const { data } = await axiosInstance.post('admin/product/store', newProduct);
      error.value = null;
    } catch (err) {
      error.value = err.response.data.message;
      console.error("API Error:", err);
    } finally {
      loading.value = false;
    }
  };

  // Update an existing product
  const updateProduct = async (id, updatedProduct) => {
    try {
      loading.value = true;
      const { data } = await axiosInstance.post(`admin/product/update/${id}`, updatedProduct);
      error.value = null;
    } catch (err) {
      error.value = err.response.data.message;
      console.error("API Error:", err);
    } finally {
      loading.value = false;
    }
  };

  // Delete a product
  const deleteProduct = async (id) => {
    try {
      loading.value = true;
      await axiosInstance.post(`admin/product/destroy/${id}`);
      products.value = products.value.filter((product) => product.id !== id); // Remove the deleted product from the list
      error.value = null;
    } catch (err) {
      error.value = "Failed to delete product";
      console.error("API Error:", err);
    } finally {
      loading.value = false;
    }
  };

  return {
    products,
    error,
    loading,
    fetchProduct,
    fetchPublicProduct,
    showProduct,
    createProduct,
    updateProduct,
    deleteProduct,
  };
});

export default useProduct;
