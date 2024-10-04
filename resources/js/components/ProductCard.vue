<template>
    <div class="bg-white shadow-lg rounded-lg p-4 flex-col justify-between">
        <img :src="product.image" :alt="product.name" class="w-full h-32 object-cover rounded-t-lg mb-4">
        <h3 class="text-l font-semibold mb-2 h-12">{{ product.name }}</h3>
        <div class="flex justify-between items-center content-around">
            <p class="text-blue-700 text-l font-bold mb-4">$ {{ product.price }}</p>
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                @click="$emit('add-to-cart', product)">
                Add to Cart
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        product: {
            type: Object,
            required: true,
        },
    },
};
</script>

<style scoped></style>
