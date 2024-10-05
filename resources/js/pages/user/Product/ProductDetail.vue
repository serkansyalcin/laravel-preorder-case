<template>
    <div class="container mx-auto p-4">
        <div class="flex flex-col md:flex-row">
            <!-- Product Image -->
            <div class="md:w-1/2">
                <img :src="product.imageUrl" alt="Product Image" class="w-full h-96 object-cover rounded-lg" />
            </div>

            <!-- Product Details -->
            <div class="md:w-1/2 md:ml-8 mt-6 md:mt-0">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ product.name }}</h1>
                <p class="text-gray-600 mb-4">{{ product.description }}</p>

                <div class="text-xl font-semibold text-blue-600 mb-4">${{ product.price }}</div>

                <RouterLink to="/">
                    <button class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none">
                        Back to home
                    </button>
                </RouterLink>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

const product = ref({});
const route = useRoute();

// Mock fetch product function based on the product ID
const fetchProduct = (id) => {
    // Mocked product data (replace with actual API call)
    const products = [
        {
            id: 1,
            name: 'Nike Dunk Low Women',
            description: 'This is the description of Product 1.',
            price: 49.99,
            imageUrl: 'https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/af53d53d-561f-450a-a483-70a7ceee380f/W+NIKE+DUNK+LOW.png',
        },
        {
            id: 2,
            name: 'Nike SB Force 58 Premium Skate Shoes',
            description: 'This is the description of Product 2.',
            price: 59.99,
            imageUrl: 'https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/da8e413a-ea84-4602-88ff-05921db36358/NIKE+SB+FORCE+58+PRM+L.png',
        },
        {
            id: 3,
            name: "Nike Cortez Leather Men's Shoes",
            description: 'This is the description of Product 2.',
            price: 59.99,
            imageUrl: 'https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/3f6f52e9-f18a-4eb2-8788-61bc06f08a5a/NIKE+CORTEZ.png',
        },
        {
            id: 4,
            name: "Nike Air Force 1 '07 Men's Shoes",
            description: 'This is the description of Product 2.',
            price: 59.99,
            imageUrl: 'https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/51a183a0-6e1b-4de7-a1ca-ba88b9bbb36f/AIR+FORCE+1+%2707.png',
        },
    ];

    // Find the product by ID
    return products.find((prod) => prod.id === id);
};

// Load the product details when component is mounted
onMounted(() => {
    const productId = parseInt(route.params.productId, 10);
    product.value = fetchProduct(productId); // Replace with an API call
});
</script>

<style scoped>
/* Add your styles here if necessary */
</style>
