<template>
    <transition name="fade">
        <div v-if="isVisible" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">{{ title }}</h3>
                <p class="text-gray-600 mb-6">{{ message }}</p>

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
