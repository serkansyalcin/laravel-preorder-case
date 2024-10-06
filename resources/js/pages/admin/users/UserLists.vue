<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Users</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        #</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        First Name</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Last Name</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Phone</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Email</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in userStore.users" :key="user.id" class="hover:bg-gray-100">
                    <td class="px-6 py-4 border-b border-gray-300">{{ index + 1 }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ user.first_name }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ user.last_name }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ user.phone }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ user.email }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import axiosInstance from "../../../lib/axios";
import useUser from "../../../store/user";

const userStore = useUser();

onMounted(async () => {
    try {
        await axiosInstance.get("/admin/check");
        await userStore.fetchUsers();
    } catch (err) {
        console.error('Error fetching product data:', err);
    }
});
</script>