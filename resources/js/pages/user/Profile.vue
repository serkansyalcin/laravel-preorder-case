<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white shadow-md rounded-lg p-6 max-w-md w-full">
            <h2 class="text-2xl font-bold mb-4 text-center">Profile</h2>

            <!-- Display user data -->
            <div v-if="dataUser.user" class="space-y-4">
                <div class="text-lg">
                    <strong>First Name:</strong> {{ dataUser.user.first_name }}
                </div>
                <div class="text-lg">
                    <strong>Last Name:</strong> {{ dataUser.user.last_name }}
                </div>
                <div class="text-lg">
                    <strong>Email:</strong> {{ dataUser.user.email }}
                </div>
                <div class="text-lg">
                    <strong>Phone:</strong> {{ dataUser.user.phone }}
                </div>
            </div>

            <!-- Error message if user is not found -->
            <div v-else>
                <p class="text-red-500 text-center">User data not available. Please log in.</p>
            </div>

            <!-- Logout button -->
            <div class="mt-6 flex justify-center">
                <button @click="logout"
                    class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 focus:outline-none">
                    Logout
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import router from "../../router";
import useUser from '../../store/user';

const dataUser = useUser();

const logout = async () => {
    await dataUser.logout();
    router.go("/")
};
</script>
