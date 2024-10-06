<template>
    <div class="container mx-auto p-4">
        <div v-if="!showCheckoutForm">
            <h1 class="text-3xl font-bold mb-6">Product Catalog</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <ProductCard v-for="product in productStore.products" :key="product.id" :product="product"
                    @add-to-cart="addToCart" @show-product="showProduct" />
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
    <div v-if="showCheckoutForm && userStore.user != null" class="container mx-auto p-4">
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
                <label for="lastName" class="block font-medium mb-2">Billing Address</label>
                <input type="text" id="lastName" v-model="order.shipping_address"
                    class="w-full px-4 py-2 border rounded-lg" required />
            </div>
            <div class="mb-4">
                <label for="lastName" class="block font-medium mb-2">Shipping Address</label>
                <input type="text" id="lastName" v-model="order.billing_address"
                    class="w-full px-4 py-2 border rounded-lg" required />
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

    <div v-if="showCheckoutForm && userStore.user == null" class="container mx-auto p-4">
        <section class="hero-section bg-slate-400 rounded-lg shadow-md p-6">
            <div class="container mx-auto text-center py-20">
                <h1 class="text-4xl font-bold text-white">Account Information</h1>
                <p class="text-lg text-white mt-4 mb-4">To continue the order, you need to login or register</p>
                <RouterLink to="/login" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-md mr-2">
                    Login
                </RouterLink>
                <RouterLink to="/register" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-md">
                    Register
                </RouterLink>
            </div>
        </section>
    </div>

    <ProductDetailModal v-if="isVisible" :product="selectedProduct" :isVisible="isVisible" @add-to-cart="addToCart"
        @cancel="closeModal" />
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import ProductCard from './ProductCard.vue';
import ProductDetailModal from './ProductDetailModal.vue';
import useProduct from '../store/product';
import useOrderUser from '../store/orderUser'
import useUser from '../store/user'
import Swal from 'sweetalert2'

const productStore = useProduct();
const orderUserStore = useOrderUser();
const userStore = useUser();

const cart = ref([]);
const showCheckoutForm = ref(false);

const order = ref({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    billing_address: '',
    shipping_address: '',
});

const errors = ref({
    email: null,
    phone: null,
});

const selectedProduct = ref(null);
const isVisible = ref(false);

const cartTotal = computed(() => {
    return cart.value.reduce((total, item) => total + item.price * item.quantity, 0);
});

const isFormValid = computed(() => {
    return (
        order.value.firstName &&
        order.value.lastName &&
        order.value.email &&
        order.value.phone &&
        !errors.value.email &&
        !errors.value.phone
    );
});

const addToCart = (product) => {
    const cartItem = cart.value.find((item) => item.id === product.id);
    if (cartItem) {
        cartItem.quantity++;
    } else {
        cart.value.push({ ...product, quantity: 1 });
    }
    isVisible.value = false;
};

const increaseQty = (item) => {
    item.quantity++;
};

const decreaseQty = (item) => {
    if (item.quantity > 1) {
        item.quantity--;
    }
};

const removeFromCart = (item) => {
    cart.value = cart.value.filter(cartItem => cartItem.id !== item.id);
};

const checkout = () => {
    showCheckoutForm.value = true;
};

const validateEmail = () => {
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    errors.value.email = emailPattern.test(order.value.email)
        ? null
        : 'Please enter a valid email address.';
};

const validatePhone = () => {
    const phonePattern = /^[0-9]{10,15}$/;
    errors.value.phone = phonePattern.test(order.value.phone)
        ? null
        : 'Please enter a valid phone number.';
};

const submitOrder = async () => {
    if (isFormValid.value) {
        order.value.items = cart.value.map(function (value) {
            value.product_id = value.id
            value.qty = value.quantity
            return value;
        });

        try {
            await orderUserStore.createOrder(order.value);
            // Check for any error after the call
            if (orderUserStore.error == null) {
                Swal.fire({
                    title: "Succesfully!",
                    text: "Your order successfully created, please check your email to more detail",
                    icon: "success"
                });

                showCheckoutForm.value = false;
                order.value = { firstName: '', lastName: '', email: '', phone: '' }; // Reset form
                cart.value = [];
            } else {
                // Catch any unexpected errors (e.g., network issues)
                console.log("Error in component:", error);
                Swal.fire({
                    title: "Error",
                    text: "An unexpected error occurred. Please try again later.",
                    icon: "error"
                });
            }
        } catch (error) {

        }
    }
};

const showProduct = (product) => {
    selectedProduct.value = product;
    isVisible.value = true;
};

const closeModal = () => {
    isVisible.value = false;
};

onMounted(async () => {
    try {
        await productStore.fetchPublicProduct();

        if (userStore.user != null) {
            order.value.firstName = userStore.user.first_name;
            order.value.lastName = userStore.user.last_name;
            order.value.email = userStore.user.email;
            order.value.phone = userStore.user.phone;
        }
    } catch (error) {
        console.log(error);
    }
});

</script>

<style scoped></style>
