<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Products</h2>

    <!-- Add New Product Button -->
    <div class="mb-6">
        <RouterLink to="/admin/products/create">
            <button class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                Add New Product
            </button>
        </RouterLink>
    </div>

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
                        Image</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Product Name</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Price</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in products" :key="product.id" class="hover:bg-gray-100">
                    <td class="px-6 py-4 border-b border-gray-300">{{ index + 1 }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        <img :src="product.image" :alt="product.name"
                            class="w-full h-32 object-cover rounded-t-lg mb-4">
                    </td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ product.name }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">${{ product.price.toFixed(2) }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        <RouterLink :to="`/admin/products/edit/${product.id}`">
                            <button class="text-blue-500 hover:text-blue-700 mr-4">
                                Edit
                            </button>
                        </RouterLink>
                        <button @click="showConfirmDelete(product)" class="text-red-500 hover:text-red-700">
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

const products = ref([
    { id: 1, name: "Nike Dunk Low Women", price: 499, image: "https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/af53d53d-561f-450a-a483-70a7ceee380f/W+NIKE+DUNK+LOW.png" },
    { id: 2, name: "Nike SB Force 58 Premium Skate Shoes", price: 399, image: "https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/da8e413a-ea84-4602-88ff-05921db36358/NIKE+SB+FORCE+58+PRM+L.png" },
    { id: 3, name: "Nike Cortez Leather Men's Shoes", price: 259, image: "https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/3f6f52e9-f18a-4eb2-8788-61bc06f08a5a/NIKE+CORTEZ.png" },
    { id: 4, name: "Nike Air Force 1 '07 Men's Shoes", price: 419, image: "https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/51a183a0-6e1b-4de7-a1ca-ba88b9bbb36f/AIR+FORCE+1+%2707.png" },
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