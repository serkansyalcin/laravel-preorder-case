<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Profile</h2>

    <!-- Profile Image -->
    <div class="flex items-center justify-center mb-6">
        <div class="relative">
            <img class="h-32 w-32 rounded-full object-cover" :src="profileImage" alt="Profile Image" />
            <button @click="updateProfileImage"
                class="absolute bottom-0 right-0 bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l5 5L20 7" />
                </svg>
            </button>
        </div>
    </div>
    <!-- Profile Form -->
    <form @submit.prevent="updateProfile">
        <!-- First Name -->
        <div class="mb-4">
            <label class="block text-gray-700">First Name</label>
            <input v-model="first_name" type="text"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter your first name" />
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Last Name</label>
            <input v-model="last_name" type="text"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter your first name" />
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input v-model="email" type="email"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter your email" />
        </div>

        <!-- Phone Number -->
        <div class="mb-4">
            <label class="block text-gray-700">Phone Number</label>
            <input v-model="phoneNumber" type="text"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter your phone number" />
        </div>

        <!-- Update Button -->
        <div class="mt-6">
            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                Update Profile
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axiosInstance from "../../../lib/axios";
import useUser from '../../../store/user';

onMounted(async () => {
    await axiosInstance.get("/admin/check");
});

const dataUser = useUser();

const first_name = ref(dataUser.user.first_name);
const last_name = ref(dataUser.user.last_name);
const email = ref(dataUser.user.email);
const phoneNumber = ref(dataUser.user.phoneNumber);

const profileImage = ref("https://via.placeholder.com/150");

const updateProfile = () => {
    console.log("Profile updated:", name, email, phoneNumber);
}
const updateProfileImage = () => {
    console.log("Profile image updated");
}

</script>