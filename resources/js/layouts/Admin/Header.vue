<template>
  <Navigation />
</template>

<script setup>
import Navigation from "../../components/Navigation.vue";
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
