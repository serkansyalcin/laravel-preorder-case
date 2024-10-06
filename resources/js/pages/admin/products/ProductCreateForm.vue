<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Product</h2>

    <form @submit.prevent="submitForm" novalidate>
        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-600 mb-2">Product Name</label>
            <input id="name" type="text" v-model="form.name"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                :class="{ 'border-red-500': errors.name }" />
            <p v-if="errors.name" class="text-red-500 text-sm mt-2">{{ errors.name }}</p>
        </div>

        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-600 mb-2">SKU</label>
            <input id="name" type="text" v-model="form.sku"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                :class="{ 'border-red-500': errors.sku }" />
            <p v-if="errors.sku" class="text-red-500 text-sm mt-2">{{ errors.sku }}</p>
        </div>

        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-600 mb-2">Category</label>
            <select v-model="form.category_id"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                :class="{ 'border-red-500': errors.category_id }">
                <option value="">select category</option>
                <option v-for="(category, index) in categoryStore.categories" :key="category.id" :value="category.id">{{
                    category.name }}</option>
            </select>
            <p v-if="errors.category_id" class="text-red-500 text-sm mt-2">{{ errors.category_id }}</p>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-sm font-semibold text-gray-600 mb-2">Price ($)</label>
            <input id="price" type="number" v-model="form.price"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                :class="{ 'border-red-500': errors.price }" />
            <p v-if="errors.price" class="text-red-500 text-sm mt-2">{{ errors.price }}</p>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-semibold text-gray-600 mb-2">Product Image</label>
            <input id="image" type="file" @change="handleImageUpload"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <p v-if="errors.image" class="text-red-500 text-sm mt-2">{{ errors.image }}</p>

            <div v-if="imagePreview" class="mt-4">
                <img :src="imagePreview" alt="Product Image Preview" class="w-40 h-40 object-cover rounded-md" />
            </div>
        </div>

        <div class="mt-6">
            <button @click="showConfirmInsert" type="button"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                Create Product
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
import useProduct from '../../../store/product';
import useCategory from '../../../store/category';
import router from '../../../router';
import Swal from 'sweetalert2'

const productStore = useProduct();
const categoryStore = useCategory();

const form = ref({
    name: '',
    price: '',
    category_id: '',
    sku: '',
    image: null,
});

onMounted(async () => {
    try {
        await categoryStore.fetchCategory();
    } catch (err) {
        console.error('Error fetching product data:', err);
    }
});

const errors = ref({});
const imagePreview = ref(null);

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
        newErrors.name = 'Product name is required';
    }
    if (!form.value.price || form.value.price <= 0) {
        newErrors.price = 'Please enter a valid price';
    }

    if (!form.value.sku || form.value.sku <= 0) {
        newErrors.sku = 'Please enter a valid sku';
    }

    if (!form.value.category_id || form.value.category_id <= 0) {
        newErrors.category_id = 'Please select a category';
    }

    if (!form.value.image) {
        newErrors.image = 'Product image is required';
    }
    errors.value = newErrors;

    return Object.keys(newErrors).length === 0;
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.value.image = file;

        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submitForm = async () => {
    if (validateForm()) {
        const formData = new FormData();
        formData.append('name', form.value.name);
        formData.append('price', form.value.price);
        formData.append('image', form.value.image);
        formData.append('sku', form.value.sku);
        formData.append('category_id', 1);

        try {
            await productStore.createProduct(formData);

            if (productStore.error == null) {
                Swal.fire({
                    title: "Created!",
                    text: "The product was successfully created",
                    icon: "success"
                });
                router.push("/admin/products");
            } else {
                Swal.fire({
                    title: "Something went wrong!",
                    text: productStore.error,
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
