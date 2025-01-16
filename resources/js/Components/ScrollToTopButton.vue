<template>
    <button
        v-if="showScrollButton"
        @click="scrollToTop"
        class="fixed bottom-6 left-3 bg-gradient-to-r from-primary to-primary-dark shadow-button rounded-full p-4 hover:scale-110 transition-transform"
    >
        <img
            src="https://www.2befresh.nl/wp-content/uploads/2023/02/Back-2-Top-Button-1-1.png"
            alt="Back to Top"
            class="h-20 w-20"
        >
    </button>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const showScrollButton = ref(false);

// Method to scroll to the top
const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
};

// Method to check scroll position
const handleScroll = () => {
    showScrollButton.value = window.scrollY > 300;
};

// Attach and detach scroll event listener
onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});
</script>
