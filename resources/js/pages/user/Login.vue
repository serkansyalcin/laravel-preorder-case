<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
            <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

            <!-- Login Form -->
            <form @submit.prevent="submitForm" class="space-y-6">
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input v-model="email" type="email" id="email"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your email" required />
                    <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <input v-model="password" type="password" id="password"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your password" required />
                    <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</p>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none">
                        Login
                    </button>
                </div>

                <!-- Error Message -->
                <div v-if="formError" class="text-red-500 text-center mt-4">
                    {{ formError }}
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import router from '../../router';
import useUser from '../../store/user';

const email = ref('');
const password = ref('');
const errors = ref({});
const formError = ref('');
const user = useUser();

// Validate email format
const validateEmail = (email) => {
    const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return re.test(String(email).toLowerCase());
};


const submitForm = () => {
    // Reset error states
    errors.value = {};
    formError.value = '';

    // Validate form
    if (!validateEmail(email.value)) {
        errors.value.email = 'Please enter a valid email address.';
    }
    if (password.value.length < 6) {
        errors.value.password = 'Password must be at least 6 characters long.';
    }

    // If no validation errors, proceed with form submission logic
    if (!errors.value.email && !errors.value.password) {
        // Simulate login process (replace with actual login logic or API call)
        user.loginUser(email.value, password.value).then((result) => {
            router.go("/")
        }).catch((err) => {
            formError.value = 'Invalid email or password.';
        });
    }
};
</script>

<style scoped>
/* Add any additional styles here if needed */
</style>
