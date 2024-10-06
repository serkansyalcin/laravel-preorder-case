<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Categories</h2>

    <div class="mb-6">
        <RouterLink to="/admin/categories/create">
            <button class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                Add New Category
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
                        Name</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Slug</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(category, index) in categoryStore.categories" :key="category.id" class="hover:bg-gray-100">
                    <td class="px-6 py-4 border-b border-gray-300">{{ index + 1 }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ category.name }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ category.slug }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        <RouterLink :to="`/admin/categories/edit/${category.id}`">
                            <button class="text-blue-500 hover:text-blue-700 mr-4">
                                Edit
                            </button>
                        </RouterLink>
                        <button @click="showConfirmDelete(category)" class="text-red-500 hover:text-red-700">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Confirmation Modal -->
        <ConfirmationBox v-if="isModalVisible" title="Delete category"
            :message="`Are you sure you want to delete ${selectedCategory.name}?`" :isVisible="isModalVisible"
            @confirm="deletecategory" @cancel="closeModal" />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axiosInstance from "../../../lib/axios";
import ConfirmationBox from "../../../components/ConfirmationBox.vue";
import useCategory from '../../../store/category'
import Swal from 'sweetalert2'

const categoryStore = useCategory();

onMounted(async () => {
    try {
        await axiosInstance.get("/admin/check");
        await categoryStore.fetchCategory();
    } catch (err) {
        console.error('Error fetching category data:', err);
    }
});

const isModalVisible = ref(false);
const selectedCategory = ref(null);

const showConfirmDelete = (category) => {
    selectedCategory.value = category;
    isModalVisible.value = true;
};

const closeModal = () => {
    isModalVisible.value = false;
    selectedCategory.value = null;
};

const deletecategory = () => {
    var id = selectedCategory.value.id;
    categoryStore.deleteCategory(id);
    closeModal()

    Swal.fire({
        title: "Deleted!",
        text: "The category successfully deleted",
        icon: "success"
    });
};
</script>