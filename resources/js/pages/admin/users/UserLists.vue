<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Users</h2>

    <!-- Products Table -->
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
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users" :key="user.id" class="hover:bg-gray-100">
                    <td class="px-6 py-4 border-b border-gray-300">{{ index + 1 }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ user.firstName }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ user.lastName }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ user.phone }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ user.email }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        <RouterLink :to="`/admin/products/edit/${user.id}`">
                            <button class="text-blue-500 hover:text-blue-700 mr-4">
                                Edit
                            </button>
                        </RouterLink>
                        <button @click="showConfirmDelete(user)" class="text-red-500 hover:text-red-700">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Confirmation Modal -->
        <ConfirmationBox v-if="isModalVisible" title="Delete Product"
            :message="`Are you sure you want to delete ${selectedProduct.name}?`" :isVisible="isModalVisible"
            @confirm="deleteProduct" @cancel="closeModal" />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axiosInstance from "../../../lib/axios";
import ConfirmationBox from "../../../components/ConfirmationBox.vue";
import router from "../../../router";


onMounted(async () => {
    await axiosInstance.get("/admin/check");
});

const isModalVisible = ref(false);
const selectedProduct = ref(null);

const showConfirmDelete = (product) => {
    selectedProduct.value = product;
    isModalVisible.value = true;
};

const closeModal = () => {
    isModalVisible.value = false;
    selectedProduct.value = null;
};

const users = ref([
    { id: 1, firstName: "John", lastName: "Doe", phone: 499, email: 'john@mail.com' },
    { id: 2, firstName: "Katie", lastName: "Jackson", phone: 399, email: 'john@mail.com' },
    { id: 3, firstName: "Stephanie", lastName: "Mrs.", phone: 259, email: 'john@mail.com' },
    { id: 4, firstName: "Stepahanie", lastName: "Mrs.", phone: 419, email: 'john@mail.com' },
]);

const editProduct = (product) => {
    console.log('Edit product:', product);
    // Logic to edit the product (e.g., navigate to an edit page or open a modal with product details)
};

const deleteProduct = () => {
    var id = selectedProduct.value.id;
    products.value = products.value.filter((product) => product.id !== id);
    console.log('Product deleted:', id);
    closeModal()
};
</script>