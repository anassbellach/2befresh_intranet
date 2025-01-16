<template>
    <div class="bg-[#FCFCFC] flex flex-col min-h-screen relative overflow-hidden">
        <!-- Gradient Circle Top Left -->
        <div class="absolute top-[-950px] left-[-300px] sm:top-[-350px] sm:left-[-300px] md:top-[-520px] md:left-[-600px] lg:top-[-520px] lg:left-[-500px]
                     bg-gradient-to-br from-pink-500 via-red-500 to-orange-500 rounded-full opacity-90 overflow-hidden"
             style="width: 750px; height: 750px;">
            <img src="https://www.2befresh.nl/wp-content/uploads/2022/08/Screenshot-2022-08-31-at-10.33.34.png"
                 alt="Top Left Image" class="w-full h-full opacity-40 object-cover">
        </div>

        <!-- Gradient Circle Top Right with Image -->
        <div class="absolute top-[-400px] right-[-450px] sm:top-[-350px] sm:right-[-300px] md:top-[-500px] md:right-[-480px] lg:top-[-380px] lg:right-[-350px]
                    bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 rounded-full opacity-90 overflow-hidden"
             style="width: 750px; height: 750px;">
            <img src="https://www.2befresh.nl/wp-content/uploads/2023/01/Marketingbureau-2BeFresh.jpg"
                 alt="Top Right Image" class="w-full h-full opacity-10 object-cover">
        </div>

        <!-- Navbar -->
        <NavBar class="w-full p-4 flex fixed mt-4 h-20"></NavBar>

        <!-- Main content area with padding to account for the fixed navbar -->
        <div class="flex-grow mt-36 rounded-2xl relative">
            <slot></slot>
            <ScrollToTopButton />
        </div>

        <!-- Footer -->
        <footer class="pb-2">
            <p class="text-center">© 2BeFresh B.V. 2025</p>
        </footer>
    </div>
</template>

<script setup>
import NavBar from "@/Components/NavBar.vue";
import ScrollToTopButton from "@/Components/ScrollToTopButton.vue";
</script>
