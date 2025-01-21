<template>
    <transition
        enter-active-class="transition-opacity duration-500"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-500"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="showFlash"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 px-6 py-3 rounded-3xl text-white shadow-lg bg-green-500 z-50"
            role="alert"
        >
            <div @click="hideFlashMessage" class="flex items-center justify-between hover:cursor-pointer">
                <span>{{ $page.props.flash.success }}</span>
            </div>
        </div>
    </transition>
</template>

<script setup>
import {usePage} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";

const page = usePage();
const showFlash = ref(!!page.props.flash.success);

// Hide flash message after 5 seconds
const hideFlashMessage = () => {
    showFlash.value = false;
};

onMounted(() => {
    if (showFlash.value) {
        setTimeout(hideFlashMessage, 5000);
    }
});
</script>
