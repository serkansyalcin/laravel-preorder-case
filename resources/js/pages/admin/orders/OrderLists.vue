<template>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Orders</h2>

    <!-- orders Table -->
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
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(order, index) in orderStore.orders" :key="order.id" class="hover:bg-gray-100">
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
                    <td class="px-6 py-4 border-b border-gray-300">
                        <button @click="showConfirmDelete(order)" class="text-blue-500 hover:text-blue-700"
                            v-if="order.status == 'pending'">
                            Confirm Order
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Confirmation Modal -->
    <ConfirmationOrderBox v-if="isModalVisible" title="Confirm this order?"
        :message="`Are you sure you want to confirm this order : ${selectedOrder.order_number}?`"
        :isVisible="isModalVisible" @confirm="confirmOrder" @cancel="closeModal" :selectedOrder="selectedOrder" />
</template>

<script setup>
import { ref, onMounted } from "vue";
import axiosInstance from "../../../lib/axios";
import ConfirmationOrderBox from "../../../components/ConfirmationOrderBox.vue";
import router from "../../../router";
import useOrder from '../../../store/order'
import Swal from 'sweetalert2'

const orderStore = useOrder();

onMounted(async () => {
    await axiosInstance.get("/admin/check");
    await orderStore.fetchOrder();
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

const confirmOrder = () => {
    var id = selectedOrder.value.id;
    orderStore.updateStatus(id, {
        id: id,
        status: 'approved'
    });

    Swal.fire({
        title: "Approved!",
        text: "The order was successfully approved",
        icon: "success"
    });

    selectedOrder.value.status = "approved";

    closeModal()
};
</script>