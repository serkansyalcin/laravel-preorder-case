<template>
    <transition name="fade">
        <div v-if="isVisible" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/2">
                        <img :src="product.image" :alt="product.name" class="w-full h-96 object-cover rounded-lg" />
                    </div>

                    <div class="md:w-1/2 md:ml-8 mt-6 md:mt-0">
                        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ product.name }}</h1>
                        <p class="text-gray-600 mb-4">{{ product.description }}</p>

                        <div class="text-xl font-semibold text-blue-600 mb-4">${{ product.price }}</div>

                        <button @click="addToCart(product)"
                            class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none">
                            Add to cart
                        </button>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button @click="close" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import { ref } from 'vue';

export default {
    props: {
        product: {
            type: Object,
            default: {
                id: 1,
                name: 'Nike Dunk Low Women',
                description: 'This is the description of Product 1.',
                price: 49.99,
                imageUrl: 'https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/af53d53d-561f-450a-a483-70a7ceee380f/W+NIKE+DUNK+LOW.png',
            }
        },
        isVisible: {
            type: Boolean,
            default: false,
        },
    },
    setup(props, { emit }) {
        const addToCart = (product) => {
            emit("add-to-cart", product);
        };

        const close = () => {
            emit("cancel");
        };

        return {
            addToCart,
            close,
        };
    },
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
