<template>
    <nav class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <a href="#" class="text-2xl font-bold text-gray-800">PreOrder</a>
                </div>
                <div class="md:hidden">
                    <button @click="isOpen = !isOpen" type="button"
                        class="text-gray-800 hover:text-gray-600 focus:outline-none focus:text-gray-600">
                        <svg v-if="!isOpen" class="h-6 w-6" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                        </svg>
                        <svg v-else class="h-6 w-6" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="hidden md:flex md:items-center md:space-x-6">
                    <RouterLink class="text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium"
                        active-class="bg-gray-200" to="/admin">Dashboard</RouterLink>
                    <RouterLink to="/admin/products" active-class="bg-gray-200"
                        class="text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">Products
                    </RouterLink>
                    <RouterLink to="/admin/orders" active-class="bg-gray-200"
                        class="text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">Orders
                    </RouterLink>
                    <RouterLink to="/admin/users" active-class="bg-gray-200"
                        class="text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">Users
                    </RouterLink>
                    <RouterLink to="/admin/categories" active-class="bg-gray-200"
                        class="text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">Categories
                    </RouterLink>
                    <RouterLink to="/admin/profile" active-class="bg-gray-200"
                        class="text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">{{
                            dataUser.user.first_name
                        }}
                    </RouterLink>
                    <button @click="logout" class="px-4 py-2 bg-red-600 text-white text-sm rounded-md">
                        Logout
                    </button>
                </div>
            </div>
        </div>
        <div v-if="isOpen" class="md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <RouterLink to="/admin" active-class="bg-gray-200"
                    class="block text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-base font-medium">
                    Dashboard</RouterLink>
                <RouterLink to="/admin/products" active-class="bg-gray-200"
                    class="block text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-base font-medium">
                    Products</RouterLink>
                <RouterLink to="/admin/orders" active-class="bg-gray-200"
                    class="block text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-base font-medium">
                    Orders</RouterLink>
                <RouterLink to="/admin/categories" active-class="bg-gray-200"
                    class="block text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-base font-medium">
                    Categories</RouterLink>
                <RouterLink to="/admin/profile" active-class="bg-gray-200"
                    class="block text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-base font-medium">{{
                        dataUser.user.last_name
                    }}</RouterLink>
                <button @click="logout" class="px-4 py-2 bg-red-600 text-white text-sm rounded-md">
                    Logout
                </button>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref } from "vue";
import router from "../router";
import useUser from '../store/user';

const dataUser = useUser();
const isOpen = ref(false);

const logout = async () => {
    await dataUser.logout();
    router.push({
        name: 'AdminLogin'
    })
};
</script>
