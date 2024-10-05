<template>
    <div class="container mx-auto p-4">
        <div v-if="!showCheckoutForm">
            <h1 class="text-3xl font-bold mb-6">Product Catalog</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <ProductCard v-for="product in products" :key="product.id" :product="product" @add-to-cart="addToCart"
                    @show-product="showProduct" />
            </div>
        </div>
        <!-- Cart Table -->
        <div v-if="cart.length" class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Cart</h2>
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="py-3 px-4" width="40%">Product</th>
                        <th class="py-3 px-4">Price</th>
                        <th class="py-3 px-4" align="center">Quantity</th>
                        <th class="py-3 px-4">Total</th>
                        <th class="py-3 px-4" v-if="!showCheckoutForm">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in cart" :key="item.id" class="border-b">
                        <td class="py-3 px-4">{{ item.name }}</td>
                        <td class="py-3 px-4">${{ item.price }}</td>
                        <td class="py-3 px-4">
                            <div class="flex justify-center">
                                <button v-if="!showCheckoutForm" @click="decreaseQty(item)"
                                    class="px-2 rounded-md bg-red-300">-</button>
                                <span class="bg-gray-100 px-4 mx-1 rounded-md">{{ item.quantity }}</span>
                                <button v-if="!showCheckoutForm" @click="increaseQty(item)"
                                    class="px-2 rounded-md bg-red-300">+</button>
                            </div>
                        </td>
                        <td class="py-3 px-4">${{ item.quantity * item.price }}</td>
                        <td align="center" v-if="!showCheckoutForm">
                            <button class="bg-red-600 text-white py-2 px-2 rounded-md" @click="removeFromCart(item)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right py-3 px-4 font-bold">Total:</td>
                        <td class="py-3 px-4 font-bold">${{ cartTotal }}</td>
                    </tr>
                </tfoot>
            </table>
            <div class="flex justify-end" v-if="!showCheckoutForm">
                <button class=" bg-blue-600 px-3 py-2 text-white rounded-md mt-3" @click="checkout">PRE ORDER
                    NOW</button>
            </div>
        </div>
    </div>

    <!-- Order Form -->
    <div v-if="showCheckoutForm" class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Order Form</h2>
        <form @submit.prevent="submitOrder" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="firstName" class="block font-medium mb-2">First Name</label>
                <input type="text" id="firstName" v-model="order.firstName" class="w-full px-4 py-2 border rounded-lg"
                    required />
            </div>
            <div class="mb-4">
                <label for="lastName" class="block font-medium mb-2">Last Name</label>
                <input type="text" id="lastName" v-model="order.lastName" class="w-full px-4 py-2 border rounded-lg"
                    required />
            </div>
            <div class="mb-4">
                <label for="email" class="block font-medium mb-2">Email</label>
                <input type="email" id="email" v-model="order.email" class="w-full px-4 py-2 border rounded-lg" required
                    @input="validateEmail" />
                <span v-if="errors.email" class="text-red-500 text-sm">{{ errors.email }}</span>
            </div>
            <div class="mb-4">
                <label for="phone" class="block font-medium mb-2">Phone Number</label>
                <input type="tel" id="phone" v-model="order.phone" class="w-full px-4 py-2 border rounded-lg" required
                    @input="validatePhone" />
                <span v-if="errors.phone" class="text-red-500 text-sm">{{ errors.phone }}</span>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600"
                :disabled="!isFormValid">
                Submit Order
            </button>
        </form>
    </div>

    <ProductDetailModal v-if="isVisible" :product="selectedProduct" :isVisible="isVisible" @add-to-cart="addToCart"
        @cancel="closeModal" />
</template>

<script>
import ProductCard from './ProductCard.vue';
import ProductDetailModal from './ProductDetailModal.vue';

export default {
    components: {
        ProductCard,
        ProductDetailModal
    },
    data() {
        return {
            products: [
                { id: 1, name: "Nike Dunk Low Women", price: 499, image: "https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/af53d53d-561f-450a-a483-70a7ceee380f/W+NIKE+DUNK+LOW.png" },
                { id: 2, name: "Nike SB Force 58 Premium Skate Shoes", price: 399, image: "https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/da8e413a-ea84-4602-88ff-05921db36358/NIKE+SB+FORCE+58+PRM+L.png" },
                { id: 3, name: "Nike Cortez Leather Men's Shoes", price: 259, image: "https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/3f6f52e9-f18a-4eb2-8788-61bc06f08a5a/NIKE+CORTEZ.png" },
                { id: 4, name: "Nike Air Force 1 '07 Men's Shoes", price: 419, image: "https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/51a183a0-6e1b-4de7-a1ca-ba88b9bbb36f/AIR+FORCE+1+%2707.png" },
            ],
            cart: [],
            showCheckoutForm: false,
            order: {
                firstName: '',
                lastName: '',
                email: '',
                phone: '',
            },
            errors: {
                email: null,
                phone: null,
            },
            selectedProduct: null,
            isVisible: false
        };
    },
    computed: {
        cartTotal() {
            return this.cart.reduce((total, item) => total + item.price * item.quantity, 0);
        },
        isFormValid() {
            return this.order.firstName && this.order.lastName && this.order.email && this.order.phone && !this.errors.email && !this.errors.phone;
        },
    },
    methods: {
        addToCart(product) {
            const cartItem = this.cart.find((item) => item.id === product.id);
            if (cartItem) {
                cartItem.quantity++;
            } else {
                this.cart.push({ ...product, quantity: 1 });
            }
            this.isVisible = false;
        },
        increaseQty(item) {
            item.quantity++;
        },
        decreaseQty(item) {
            if (item.quantity > 1) {
                item.quantity--;
            }
        },
        removeFromCart(item) {
            this.cart = this.cart.filter(cartItem => cartItem.id !== item.id);
        },
        checkout() {
            this.showCheckoutForm = true;
        }, validateEmail() {
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            this.errors.email = emailPattern.test(this.order.email) ? null : 'Please enter a valid email address.';
        },
        validatePhone() {
            const phonePattern = /^[0-9]{10,15}$/;
            this.errors.phone = phonePattern.test(this.order.phone) ? null : 'Please enter a valid phone number.';
        },
        submitOrder() {
            if (this.isFormValid) {
                alert(`Order submitted for ${this.order.firstName} ${this.order.lastName}!`);
                // Handle order submission (e.g., API call)
                this.showCheckoutForm = false;
                this.order = { firstName: '', lastName: '', email: '', phone: '' }; // Reset form
                this.cart = [];
            }
        },
        showProduct(product) {
            this.selectedProduct = product;
            this.isVisible = true;
        },
        closeModal() {
            this.isVisible = false;
        }
    },
};
</script>

<style scoped></style>
