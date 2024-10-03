<template>
  <div class="min-h-screen flex items-center justify-center">
    <form
      @submit.prevent="submit"
      class="max-w-md mx-auto w-full bg-white rounded-md p-8 space-y-8"
    >
      <!-- Email Address -->
      <div class="space-y-2">
        <label class="font-medium">Email</label>
        <input
          v-model="form.email"
          class="w-full border border-gray-300 rounded-md bg-transparent"
          placeholder="mail@example.com"
        />
        <small class="text-red-500" v-if="form.invalid('email')">{{
          form.errors.email
        }}</small>
      </div>

      <!-- Password -->
      <div class="space-y-2">
        <label class="font-medium">Password</label>
        <input
          type="password"
          v-model="form.password"
          class="w-full border border-gray-300 rounded-md bg-transparent"
        />
        <small class="text-red-500" v-if="form.invalid('email')">{{
          form.errors.password
        }}</small>
      </div>

      <button
        :disabled="form.processing"
        class="w-full py-2 px-4 rounded-lg bg-sky-600 text-white"
      >
        {{ form.processing ? "Loading..." : "Login" }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from "laravel-precognition-vue";
import useUser from "../../store/user";
import router from "../../router";

const user = useUser();

const form = useForm("post", "/admin/login", {
  email: "",
  password: "",
});

const submit = () => {
  form.submit().then(({ data }) => {
    user.login(data.token, data.data);
    router.push("/admin");
  });
};
</script>
