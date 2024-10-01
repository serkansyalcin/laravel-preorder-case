<script setup>
import Header from "./Header.vue";
</script>

<template>
  <Header />

  <main class="container">
    <div class="p-4 bg-white rounded-xl">
      <RouterView />
    </div>
  </main>
</template>
