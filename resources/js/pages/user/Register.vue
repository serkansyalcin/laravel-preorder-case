<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
            <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

            <form @submit.prevent="submitForm" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        First Name
                    </label>
                    <input v-model="first_name" type="text" id="first_name"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your first name" required />
                    <p v-if="errors.first_name" class="text-red-500 text-sm mt-1">{{ errors.first_name }}</p>
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">
                        Last Name
                    </label>
                    <input v-model="last_name" type="text" id="last_name"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your last name" required />
                    <p v-if="errors.last_name" class="text-red-500 text-sm mt-1">{{ errors.last_name }}</p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input v-model="email" type="email" id="email"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your email" required />
                    <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        Phone
                    </label>
                    <input v-model="phone" type="text" id="phone"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your phone number" required />
                    <p v-if="errors.phone" class="text-red-500 text-sm mt-1">{{ errors.phone }}</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <input v-model="password" type="password" id="password"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your password" required />
                    <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirm Password
                    </label>
                    <input v-model="password_confirmation" type="password" id="password_confirmation"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your password" required />
                    <p v-if="errors.password_confirmation" class="text-red-500 text-sm mt-1">{{
                        errors.password_confirmation }}</p>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none">
                        Login
                    </button>
                </div>

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
import Swal from 'sweetalert2'

const first_name = ref('');
const last_name = ref('');
const email = ref('');
const phone = ref('');
const password = ref('');
const password_confirmation = ref('');
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
    if (first_name.value.length == 0) {
        errors.value.first_name = 'first name is required.';
    }

    if (last_name.value.length == 0) {
        errors.value.last_name = 'last name is required.';
    }

    if (!validateEmail(email.value)) {
        errors.value.email = 'Please enter a valid email address.';
    }
    if (password.value.length < 6) {
        errors.value.password = 'Password must be at least 6 characters long.';
    }

    if (password_confirmation.value.length < 6) {
        errors.value.password_confirmation = 'Confirm Password must be at least 6 characters long.';
    }

    if (password.value != password_confirmation.value) {
        errors.value.password_confirmation = 'Password confirmation not match.';
    }

    if (!errors.value.first_name && !errors.value.last_name && !errors.value.email && !errors.value.password) {

        const formData = {
            first_name: first_name.value,
            last_name: last_name.value,
            email: email.value,
            phone: phone.value,
            password: password.value,
            password_confirmation: password_confirmation.value
        }

        console.log(formData);

        user.registerUser(formData).then((result) => {
            Swal.fire({
                title: "Success!",
                text: "Register successfully",
                icon: "success"
            }).then(() => {
                router.push('/');
            });
        }).catch((err) => {
            console.log(err)
            Swal.fire({
                title: "Something went wrong!",
                text: user.error, // Display the error message
                icon: "warning"
            });
        });
    }
};
</script>

<style scoped>
/* Add any additional styles here if needed */
</style>
