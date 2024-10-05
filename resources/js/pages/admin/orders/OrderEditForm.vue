<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Product</h2>

    <form @submit.prevent="submitForm" novalidate>
        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-600 mb-2">Product Name</label>
            <input id="name" type="text" v-model="form.name"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                :class="{ 'border-red-500': errors.name }" />
            <p v-if="errors.name" class="text-red-500 text-sm mt-2">{{ errors.name }}</p>
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

            <div v-if="existingImage && !imagePreview" class="mt-4">
                <img :src="existingImage" alt="Existing Product Image" class="w-40 h-40 object-cover rounded-md" />
                <p class="text-sm text-gray-500 mt-2">Current Image</p>
            </div>

            <div v-if="imagePreview" class="mt-4">
                <img :src="imagePreview" alt="New Product Image Preview" class="w-40 h-40 object-cover rounded-md" />
            </div>
        </div>

        <div class="mt-6">
            <button type="button" @click="showConfirmEdit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                Update Product
            </button>
        </div>
    </form>

    <ConfirmationBox v-if="isModalVisible" title="Update product data"
        :message="`Are you sure you want to update this product?`" :isVisible="isModalVisible" @confirm="submitForm"
        @cancel="closeModal" />
</template>

<script setup>
import { ref, onMounted } from 'vue';
import ConfirmationBox from '../../../components/ConfirmationBox.vue';

const props = defineProps(
    {
        productId: {
            type: String,
            required: true,
        },
    }
)

const form = ref({
    name: '',
    price: '',
    stock: '',
    image: null,
});

const errors = ref({});
const imagePreview = ref(null);
const existingImage = ref(null);

const isModalVisible = ref(false);
const selectedProduct = ref(null);

const showConfirmEdit = (product) => {
    if (validateForm()) {
        selectedProduct.value = product;
        isModalVisible.value = true;
    }
};

const closeModal = () => {
    isModalVisible.value = false;
    selectedProduct.value = null;
};

const loadProductData = async () => {
    const product = {
        name: 'Sample Product',
        price: 49.99,
        stock: 100,
        imageUrl: 'https://via.placeholder.com/400x300',
    };

    form.value.name = product.name;
    form.value.price = product.price;
    form.value.stock = product.stock;
    existingImage.value = product.imageUrl;
};

const validateForm = () => {
    const newErrors = {};
    if (!form.value.name) {
        newErrors.name = 'Product name is required';
    }
    if (!form.value.price || form.value.price <= 0) {
        newErrors.price = 'Please enter a valid price';
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

const submitForm = () => {
    if (validateForm()) {
        const formData = new FormData();
        formData.append('name', form.value.name);
        formData.append('price', form.value.price);
        if (form.value.image) {
            formData.append('image', form.value.image);
        }
        console.log('Form submitted:', form.value);
    }
};


onMounted(() => {
    loadProductData();
});
</script>

<style scoped>
/* Scoped styles for the form */
</style>
