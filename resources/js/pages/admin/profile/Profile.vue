<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Profile</h2>

    <form @submit.prevent="updateProfile">
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

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input v-model="email" type="email"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter your email" />
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Phone Number</label>
            <input v-model="phoneNumber" type="text"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter your phone number" />
        </div>

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
import Swal from 'sweetalert2'

onMounted(async () => {
    await axiosInstance.get("/admin/check");
});

const dataUser = useUser();

const id = ref(dataUser.user.id);
const first_name = ref(dataUser.user.first_name);
const last_name = ref(dataUser.user.last_name);
const email = ref(dataUser.user.email);
const phoneNumber = ref(dataUser.user.phoneNumber);

const updateProfile = async () => {
    try {
        const updateData = {
            first_name: first_name.value,
            last_name: last_name.value,
            email: email.value,
            phone: phoneNumber.value,
        }
        await dataUser.updateUser(id.value, updateData);

        if (dataUser.error == null) {
            Swal.fire({
                title: "Created!",
                text: "The product was successfully created",
                icon: "success"
            });
        } else {
            Swal.fire({
                title: "Something went wrong!",
                text: dataUser.error,
                icon: "warning"
            });
        }
    } catch (error) {
        console.log("Error in component:", error);
        Swal.fire({
            title: "Error",
            text: "An unexpected error occurred. Please try again later.",
            icon: "error"
        });
    }
}

</script>