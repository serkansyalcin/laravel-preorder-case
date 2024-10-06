import { defineStore } from "pinia";
import { ref } from "vue";
import axiosInstance from "../lib/axios";
const useCategory = defineStore('category', () => {
  const categories = ref(null); // To store category list
  const error = ref(null); // To track errors
  const loading = ref(false); // To track loading state for API requests

  // Fetching category details if token is found in localstorage
  const fetchCategory = async () => {
    const localToken = localStorage.getItem("token");
    if (localToken) {
      try {
        loading.value = true;
        const { data } = await axiosInstance.get('admin/category/list');
        categories.value = data.data;
        error.value = null;
      } catch (err) {
        error.value = "Failed to fetch categories";
        console.error("API Error:", err);
      } finally {
        loading.value = false;
      }
    } else {
      error.value = "No token found";
    }
  };

  // Create a new category
  const createCategory = async (newcategory) => {
    try {
      loading.value = true;
      const { data } = await axiosInstance.post('admin/category/store', newcategory);
      error.value = null;
    } catch (err) {
      error.value = "Failed to create category";
      console.error("API Error:", err);
    } finally {
      loading.value = false;
    }
  };

  // Update an existing category
  const updateCategory = async (id, updatedCategory) => {
    try {
      loading.value = true;
      const { data } = await axiosInstance.post(`admin/category/update/${id}`, updatedCategory);
      error.value = null;
    } catch (err) {
      error.value = "Failed to update category";
      console.error("API Error:", err);
    } finally {
      loading.value = false;
    }
  };

  // Delete a category
  const deleteCategory = async (id) => {
    try {
      loading.value = true;
      await axiosInstance.post(`admin/category/destroy/${id}`);
      error.value = null;
    } catch (err) {
      error.value = "Failed to delete category";
      console.error("API Error:", err);
    } finally {
      loading.value = false;
    }
  };

  return {
    categories,
    error,
    loading,
    fetchCategory,
    createCategory,
    updateCategory,
    deleteCategory,
  };
});

export default useCategory;
