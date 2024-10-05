<script setup>
import { onMounted } from "vue";
import axiosInstance from "../../../lib/axios";

onMounted(async () => {
    await axiosInstance.get("/admin/check");
});
</script>
<template>
    <h1>Products Lists</h1>
</template>
