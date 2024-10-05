import { defineStore } from "pinia";
import { ref } from "vue";
import axiosInstance from "../lib/axios";

const useProduct = defineStore('product', () => {
  const products = ref(null)

  // Fetching the user detials if token found in localstorage
  const fetchProduct = async () => {
    const localToken = localStorage.getItem("token")
    if (localToken) {
      const { data } = await axiosInstance.get('admin/product/list')
      products.value = data.data
    }
  }

  return {
    products,
    fetchProduct
  }
})

export default useProduct;
