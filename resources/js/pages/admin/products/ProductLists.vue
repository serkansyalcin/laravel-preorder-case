<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Products</h2>

    <div class="mb-6">
        <RouterLink to="/admin/products/create">
            <button class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                Add New Product
            </button>
        </RouterLink>
    </div>

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
                <tr v-for="(product, index) in productStore.products" :key="product.id" class="hover:bg-gray-100">
                    <td class="px-6 py-4 border-b border-gray-300">{{ index + 1 }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        <img :src="product.image" :alt="product.name"
                            class="w-full h-32 object-cover rounded-t-lg mb-4">
                    </td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ product.name }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">${{ product.price }}</td>
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
import useProduct from '../../../store/product'
import Swal from 'sweetalert2'


onMounted(async () => {
    try {
        await axiosInstance.get("/admin/check");
        await productStore.fetchProduct();
    } catch (err) {
        console.error('Error fetching product data:', err);
    }
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

const deleteProduct = () => {
    var id = selectedProduct.value.id;
    productStore.deleteProduct(id);
    closeModal()

    Swal.fire({
        title: "Deleted!",
        text: "The product successfully deleted",
        icon: "success"
    });
};
</script>