<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Orders</h2>

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
                        Name</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Total ($)</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Total Items</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Status</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in products" :key="product.id" class="hover:bg-gray-100">
                    <td class="px-6 py-4 border-b border-gray-300">{{ index + 1 }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ product.name }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">${{ product.total.toFixed(2) }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ product.total_item }} items</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        <span class="px-2 py-2 bg-blue-500 text-white rounded-md">{{ product.status }}</span>
                    </td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        <button @click="showConfirmDelete(product)" class="text-blue-500 hover:text-blue-700">
                            Confirm Order
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
    { id: 1, name: "John Doe", total: 499, total_item: 3, status: 'pending' },
    { id: 2, name: "Katie Jackson", total: 399, total_item: 1, status: 'confirmed' },
    { id: 3, name: "Stephanie", total: 259, total_item: 2, status: 'finish' },
    { id: 4, name: "Stepahanie", total: 419, total_item: 4, status: 'delivery' },
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