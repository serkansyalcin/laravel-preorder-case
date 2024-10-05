<template>
    <nav class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="#" class="text-2xl font-bold text-gray-800">PreOrder</a>
                </div>
                <!-- Hamburger Menu (Mobile) -->
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
                <!-- Navigation Links -->
                <div class="hidden md:flex md:items-center md:space-x-6">
                    <RouterLink class="text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium"
                        to="/admin">Dashboard</RouterLink>
                    <RouterLink to="/admin/products"
                        class="text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">Products
                    </RouterLink>
                    <RouterLink to="/admin/orders"
                        class="text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">Orders
                    </RouterLink>
                    <RouterLink to="/admin/users"
                        class="text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">Users
                    </RouterLink>
                    <RouterLink to="/admin/profile"
                        class="text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">Profile
                    </RouterLink>
                    <button @click="logout" class="px-4 py-2 bg-red-600 text-white text-sm rounded-md">
                        Logout
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div v-if="isOpen" class="md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#"
                    class="block text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                <a href="#"
                    class="block text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-base font-medium">Products</a>
                <a href="#"
                    class="block text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-base font-medium">Orders</a>
                <a href="#"
                    class="block text-gray-800 hover:text-blue-500 px-3 py-2 rounded-md text-base font-medium">Users</a>
                <button @click="logout" class="px-4 py-2 bg-red-600 text-white text-sm rounded-md">
                    Logout
                </button>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            isOpen: false,
        };
    },
};
</script>

<style scoped>
/* Add any additional custom styles if needed */
</style>
