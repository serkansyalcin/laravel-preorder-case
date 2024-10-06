<template>
    <transition name="fade">
        <div v-if="isVisible" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h4 class="text-md font-bold text-gray-800 mb-4">Order Details</h4>
                <table class="min-w-full bg-white">
                    <tr>
                        <td
                            class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                            Order Number</td>
                        <td
                            class="px-6 py-3 border-b-2 border-gray-300 bg-white text-left text-xs font-semibold text-gray-600 uppercase">
                            {{ selectedOrder.order_number }}</td>
                    </tr>
                    <tr>
                        <td
                            class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                            Full Name</td>
                        <td
                            class="px-6 py-3 border-b-2 border-gray-300 bg-white text-left text-xs font-semibold text-gray-600 uppercase">
                            {{ selectedOrder.users.first_name }} {{ selectedOrder.users.last_name }}</td>
                    </tr>
                    <tr>
                        <td
                            class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                            Contact</td>
                        <td
                            class="px-6 py-3 border-b-2 border-gray-300 bg-white text-left text-xs font-semibold text-gray-600 uppercase">
                            {{ selectedOrder.email }} - {{ selectedOrder.phone }}</td>
                    </tr>
                    <tr>
                        <td
                            class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                            Billing Address</td>
                        <td
                            class="px-6 py-3 border-b-2 border-gray-300 bg-white text-left text-xs font-semibold text-gray-600 uppercase">
                            {{ selectedOrder.billing_address }}</td>
                    </tr>
                    <tr>
                        <td
                            class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                            Shipping Address</td>
                        <td
                            class="px-6 py-3 border-b-2 border-gray-300 bg-white text-left text-xs font-semibold text-gray-600 uppercase">
                            {{ selectedOrder.shipping_address }}</td>
                    </tr>
                </table>

                <h4 class="text-md font-bold text-gray-800 mb-4">Order Items</h4>
                <table>
                    <thead>
                        <tr>
                            <td
                                class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                                No</td>
                            <td
                                class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                                Item</td>
                            <td
                                class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                                Qty</td>
                            <td
                                class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                                Price</td>
                            <td
                                class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                                Subtotal</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in selectedOrder.order_items">
                            <td class="px-2 py-2 border-b border-gray-300">{{ index + 1 }}</td>
                            <td class="px-2 py-2 border-b border-gray-300">{{ item.product_id }}</td>
                            <td class="px-2 py-2 border-b border-gray-300">{{ item.qty }}</td>
                            <td class="px-2 py-2 border-b border-gray-300">${{ item.price }}</td>
                            <td class="px-2 py-2 border-b border-gray-300">${{ item.price * item.qty }}</td>
                        </tr>
                    </tbody>
                </table>

                <p class="text-gray-600 mt-6 mb-6">{{ message }}</p>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <button @click="cancel" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                        Cancel
                    </button>
                    <button @click="confirm" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                        Confirm
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
        title: {
            type: String,
            default: "Are you sure?",
        },
        message: {
            type: String,
            default: "Do you really want to proceed with this action?",
        },
        selectedOrder: {
            type: Object
        },
        isVisible: {
            type: Boolean,
            default: false,
        },
    },
    setup(props, { emit }) {
        const confirm = () => {
            emit("confirm");
        };

        const cancel = () => {
            emit("cancel");
        };

        return {
            confirm,
            cancel,
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
