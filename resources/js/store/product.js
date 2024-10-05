import { defineStore } from "pinia";
import { ref } from "vue";
import axiosInstance from "../lib/axios";

const useProduct = defineStore('product', () => {
  const product = ref(null)

  // Fetching the user detials if token found in localstorage
  const fetchProduct = async () => {
    const localToken = localStorage.getItem("token")

    if (localToken) {
      const config = {
        headers: { Authorization: `Bearer ${token}` }
      };

      const bodyParameters = {
        // key: "value"
      };

      const { data } = await axiosInstance.get('/products', bodyParameters,
        config)
        .then(console.log)
        .catch(console.log);

      product.value = data.data
    }
  }

  return {
    product,
    fetchProduct
  }
})

export default useUser;
