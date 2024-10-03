<template>
  <header class="container">
    <div
      class="p-4 bg-white flex items-center gap-4 justify-between rounded-md"
    >
      <router-link
        :to="{ name: 'AdminDashboard' }"
        class="block text-lg font-bold"
        >PreOrder</router-link
      >
      <button @click="logout" class="px-4 py-2 bg-red-600 text-white text-sm rounded-md">
        Logout
      </button>
    </div>
  </header>
</template>

<script setup>
import router from "../../router";
import useUser from "../../store/user";

const user = useUser();

const logout = async () => {
  await user.logout();
  router.push({
    name: 'AdminLogin'
  })
};
</script>
