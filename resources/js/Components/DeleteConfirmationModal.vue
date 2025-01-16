<template>
    <div v-if="visible" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-96 p-8">
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b pb-4 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Confirm Delete</h2>
                <button @click="handleClose" class="text-gray-400 hover:text-gray-600" aria-label="Close">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="text-gray-600 mb-8">
                <p>{{ message }}</p>
            </div>

            <!-- Modal Actions -->
            <div class="flex justify-between items-center">
                <button
                    @click="handleClose"
                    class="w-full bg-gray-200 text-gray-700 font-medium py-3 rounded-full hover:bg-gray-300 transition ease-in-out duration-150 mr-4"
                >
                    Cancel
                </button>
                <button
                    @click="handleConfirm"
                    class="w-full bg-red-500 text-white font-medium py-3 rounded-full hover:opacity-90 transition ease-in-out duration-150"
                >
                    Delete
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

// Props for the component
defineProps({
    message: { type: String, required: true },
});

// Emits for parent events
const emit = defineEmits(["confirm", "close"]); // "close" instead of "cancel"

// Internal state for modal visibility
const visible = ref(true);

// Handle the confirm action
const handleConfirm = () => {
    emit("confirm"); // Emit confirm event
    visible.value = false;
};

// Handle the close action
const handleClose = () => {
    emit("close"); // Emit close event
    visible.value = false;
};
</script>
