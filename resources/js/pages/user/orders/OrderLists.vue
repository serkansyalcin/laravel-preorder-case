<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Orders</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        #</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Order Number</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Name</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Total ($)</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Total Items</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(order, index) in orderUserStore.orders" :key="order.id"
                    class="hover:bg-gray-100 cursor-pointer" @click="showConfirmDelete(order)">
                    <td class="px-6 py-4 border-b border-gray-300">{{ index + 1 }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ order.order_number }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        <b>{{ order.users.first_name }} {{ order.users.last_name }}</b> <br>
                        <span class="text-sm">Billing Address : {{ order.billing_address }}</span> <br>
                        <span class="text-sm">Shipping Address : {{ order.shipping_address }}</span>
                    </td>
                    <td class="px-6 py-4 border-b border-gray-300">${{ order.amount }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ order.total_product }} items</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        <span class="px-2 py-2 bg-blue-500 text-white rounded-md">{{ order.status }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <OrderDetailModal v-if="isModalVisible" :isVisible="isModalVisible" @cancel="closeModal"
        :selectedOrder="selectedOrder" />
</template>

<script setup>
import { ref, onMounted } from "vue";
import OrderDetailModal from "../../../components/OrderDetailModal.vue";
import useOrderUser from "../../../store/orderUser";

const orderUserStore = useOrderUser();

onMounted(async () => {
    await orderUserStore.fetchOrder();
});

const isModalVisible = ref(false);
const selectedOrder = ref(null);

const showConfirmDelete = (order) => {
    selectedOrder.value = order;
    isModalVisible.value = true;
};

const closeModal = () => {
    isModalVisible.value = false;
    selectedOrder.value = null;
};
</script>