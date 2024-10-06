<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Category</h2>

    <form @submit.prevent="submitForm" novalidate>
        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-600 mb-2">Category Name</label>
            <input id="name" type="text" v-model="form.name"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                :class="{ 'border-red-500': errors.name }" />
            <p v-if="errors.name" class="text-red-500 text-sm mt-2">{{ errors.name }}</p>
        </div>

        <div class="mt-6">
            <button @click="showConfirmInsert" type="button"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                Create Category
            </button>
        </div>
    </form>

    <ConfirmationBox v-if="isModalVisible" title="Create product"
        :message="`Are you sure you want to insert this product?`" :isVisible="isModalVisible" @confirm="submitForm"
        @cancel="closeModal" />
</template>

<script setup>
import { ref, onMounted } from 'vue';
import ConfirmationBox from '../../../components/ConfirmationBox.vue';
import useCategory from '../../../store/category';
import router from '../../../router';
import Swal from 'sweetalert2'

const categoryStore = useCategory();

const form = ref({
    name: '',
});

const errors = ref({});

const isModalVisible = ref(false);
const selectedProduct = ref(null);

const showConfirmInsert = (product) => {
    if (validateForm()) {
        selectedProduct.value = product;
        isModalVisible.value = true;
    }
};

const closeModal = () => {
    isModalVisible.value = false;
    selectedProduct.value = null;
};

const validateForm = () => {
    const newErrors = {};
    if (!form.value.name) {
        newErrors.name = 'Category name is required';
    }
    errors.value = newErrors;

    return Object.keys(newErrors).length === 0;
};

const submitForm = async () => {
    if (validateForm()) {
        const formData = new FormData();
        formData.append('name', form.value.name);

        try {
            await categoryStore.createCategory(formData);

            if (categoryStore.error == null) {
                Swal.fire({
                    title: "Created!",
                    text: "The category was successfully created",
                    icon: "success"
                });
                router.push("/admin/categories");
            } else {
                Swal.fire({
                    title: "Something went wrong!",
                    icon: "warning"
                });
            }
        } catch (error) {
            console.log("Error in component:", error);
            Swal.fire({
                title: "Error",
                text: "An unexpected error occurred. Please try again later.",
                icon: "error"
            });
        }
        closeModal();

    }
};
</script>
