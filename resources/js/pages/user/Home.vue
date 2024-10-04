<script setup>
import { ref, onMounted } from "vue";
import axiosInstance from "../../lib/axios";
import ProductCatalog from "../../components/ProductCatalog.vue";

const apiLoading = ref(false);
const apiMessage = ref("");

onMounted(async () => {
  try {
    apiLoading.value = true;
    const { data } = await axiosInstance.get("/check");
    apiMessage.value = data.message;
  } catch (error) {
    apiMessage.value = "API is not working!";
    console.error("Error fetching API:", error);
  } finally {
    apiLoading.value = false;
  }
});
</script>

<template>
  <div v-if="apiLoading">Loading...</div>
  <div v-else>
    <p>{{ apiMessage }}</p>
  </div>
  <ProductCatalog />
</template>
