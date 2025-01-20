<template>
    <div class="fixed flex justify-center h-[7.5rem] px-4 w-full z-50">
        <!-- Outer Container (Centers the Navbar) -->
        <div class="bg-white max-w-6xl w-full flex justify-between items-center rounded-full shadow-lg relative">
            <!-- Logo Section -->
            <a class="flex items-center ml-4" href="/">
                <img src="https://www.2befresh.nl/wp-content/uploads/2023/06/website01.gif" alt="Logo" class="h-14">
            </a>

            <!-- Hamburger Menu for Mobile -->
            <button
                class="lg:hidden flex items-center text-gray-800 hover:text-[#FF9D37] p-2 mr-4"
                @click="toggleSidebar"
            >
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <!-- Navigation Section (for Desktop) -->
            <nav class="flex space-x-6 relative hidden lg:flex">
                <a href="/" class="h-[7.5rem] flex items-center text-gray-800 hover:text-[#FF9D37] font-semibold">Home</a>
                <a href="/referral" class="h-[7.5rem] flex items-center text-gray-800 hover:text-[#FF9D37] font-semibold">Referrals</a>

                <!-- Klanten Dropdown Trigger -->
                <div
                    class="relative group"
                    @mouseenter="setActiveDropdown('klantenDropdown')"
                    @mouseleave="hideDropdownWithDelay"
                >
                    <a :href="route('klant.index')" class="h-[7.5rem] text-gray-800 hover:text-[#FF9D37] font-semibold flex items-center focus:outline-none">
                        Klanten
                        <i class="ml-1 fa-solid fa-chevron-down"></i>
                    </a>
                </div>

                <div
                    class="relative group"
                    @mouseenter="setActiveDropdown('contactenDropdown')"
                    @mouseleave="hideDropdownWithDelay"
                >
                    <a
                        :href="route('contact.index')" class="h-[7.5rem] text-gray-800 hover:text-[#FF9D37] font-semibold flex items-center focus:outline-none"
                    >
                        Contacten
                        <i class="ml-1 fa-solid fa-chevron-down"></i>
                    </a>
                </div>

                <div
                    class="relative group"
                    @mouseenter="setActiveDropdown('leveranciersDropdown')"
                    @mouseleave="hideDropdownWithDelay"
                >
                    <a
                        :href="route('leverancier.index')" class="h-[7.5rem] text-gray-800 hover:text-[#FF9D37] font-semibold flex items-center focus:outline-none"
                    >
                        Leveranciers
                        <i class="ml-1 fa-solid fa-chevron-down"></i>
                    </a>
                </div>

                <a href="/gebruiker" class="h-[7.5rem] flex items-center text-gray-800 hover:text-[#FF9D37] font-semibold">Gebruikers</a>
            </nav>

            <!-- User Section (only on Desktop) -->
            <div v-if="user" class="relative flex items-center mr-4 hidden lg:flex">
                <div
                    class="h-[7.5rem] flex items-center text-gray-800 hover:text-[#FF9D37] font-semibold"
                    @mouseenter="setActiveDropdown('userDropdown')"
                    @mouseleave="hideDropdownWithDelay"
                >
                    <button
                        class="w-44 font-bold bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-3 rounded-full flex items-center justify-center hover:bg-blue-600"
                    >
                        <span>{{ user.fullName }}</span>
                        <i class="ml-2 fa-solid fa-chevron-down"></i>
                    </button>
                </div>

                <transition name="fade">
                    <div
                        v-show="activeDropdown === 'userDropdown'"
                        @mouseenter="setActiveDropdown('userDropdown')"
                        @mouseleave="hideDropdownWithDelay"
                        class="absolute top-12 mt-16 right-0 bg-white border border-gray-200 shadow-lg rounded-2xl w-48 z-50"
                    >
                        <ul class="text-gray-800">
                            <li>
                                <Link
                                    :href="route('gebruiker.show', { gebruiker: user.id })"
                                    class="block px-4 py-2 hover:bg-gray-100 rounded-t-2xl hover:text-[#FF9D37] relative group"
                                >
                                    <i class="fa-solid fa-user mr-2"></i> Profile
                                    <span
                                        class="absolute ml-2 top-1/2 transform -translate-y-1/2 w-2.5 h-2.5 bg-[#FF9D37] rounded-full opacity-0 group-hover:opacity-100"
                                    ></span>
                                </Link>
                            </li>
                            <li>
                                <Link
                                    :href="route('gebruiker.edit', {gebruiker: user.id})"
                                    class="block px-4 py-2 hover:bg-gray-100 hover:text-[#FF9D37] relative group"
                                >
                                    <i class="fa-solid fa-gear mr-2"></i> Settings
                                    <span
                                        class="absolute ml-2 top-1/2 transform -translate-y-1/2 w-2.5 h-2.5 bg-[#FF9D37] rounded-full opacity-0 group-hover:opacity-100"
                                    ></span>
                                </Link>
                            </li>
                            <li>
                                <button
                                    @click.prevent="logout"
                                    class="w-full text-left block px-4 py-2 hover:bg-gray-100 rounded-b-2xl hover:text-[#FF0000] relative group"
                                >
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                                    <span
                                        class="absolute ml-2 top-1/2 transform -translate-y-1/2 w-2.5 h-2.5 bg-[#FF0000] rounded-full opacity-0 group-hover:opacity-100"
                                    ></span>
                                </button>
                            </li>
                        </ul>

                    </div>
                </transition>
            </div>

            <!-- Login Button (when user is not logged in) -->
            <div v-else class="relative flex items-center mr-4 hidden lg:flex">
                <button
                    @click="redirectToLogin"
                    class="w-44 font-bold bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-3 rounded-full flex items-center justify-center hover:bg-blue-600"
                >
                    Login
                </button>
            </div>
        </div>

        <!-- Dropdown Menu Section (Positioned below the navbar) -->
        <div
            v-show="activeDropdown === 'klantenDropdown'"
            class="fixed rounded-2xl left-1/2 transform -translate-x-1/2 top-16 mt-16 bg-white border border-gray-200 shadow-xl px-6 py-8 max-w-6xl w-full z-40 transition-all duration-300 opacity-0"
            :class="{ 'opacity-100 translate-y-0': activeDropdown === 'klantenDropdown', 'translate-y-5': activeDropdown !== 'klantenDropdown' }"
            @mouseenter="setActiveDropdown('klantenDropdown')"
            @mouseleave="hideDropdownWithDelay"
        >
            <div class="flex justify-around gap-x-4">
                <a :href="route('klant.index')" class="text-gray-800 hover:text-[#FF9D37] font-medium">
                    Klantenlijst
                    <span class="ml-2 w-2.5 h-2.5 bg-[#FF9D37] rounded-full inline-block align-middle"></span>
                </a>
                <a :href="route('klant.create')" class="text-gray-800 hover:text-[#FF9D37] font-medium">
                    Klant aanmaken
                    <span class="ml-2 w-2.5 h-2.5 bg-[#FF9D37] rounded-full inline-block align-middle"></span>
                </a>
                <a href="/klant/kaart" class="text-gray-800 hover:text-[#FF9D37] font-medium">
                    Klanten kaart
                    <span class="ml-2 w-2.5 h-2.5 bg-[#FF9D37] rounded-full inline-block align-middle"></span>
                </a>
                <a href="/klant/statistieken" class="text-gray-800 hover:text-[#FF9D37] font-medium">
                    Klant statistieken
                    <span class="ml-2 w-2.5 h-2.5 bg-[#FF9D37] rounded-full inline-block align-middle"></span>
                </a>
            </div>
        </div>

        <!-- Dropdown Menu Section (Positioned below the navbar) -->
        <div
            v-show="activeDropdown === 'contactenDropdown'"
            class="fixed rounded-2xl left-1/2 transform -translate-x-1/2 top-16 mt-16 bg-white border border-gray-200 shadow-xl px-6 py-8 max-w-6xl w-full z-40 transition-all duration-300 opacity-0"
            :class="{ 'opacity-100 translate-y-0': activeDropdown === 'contactenDropdown', 'translate-y-5': activeDropdown !== 'contactenDropdown' }"
            @mouseenter="setActiveDropdown('contactenDropdown')"
            @mouseleave="hideDropdownWithDelay"
        >
            <div class="flex justify-around gap-x-4">
                <a :href="route('contact.index')" class="text-gray-800 hover:text-[#FF9D37] font-medium">
                    Contactenlijst
                    <span class="ml-2 w-2.5 h-2.5 bg-[#FF9D37] rounded-full inline-block align-middle"></span>
                </a>
                <a :href="route('contact.create')" class="text-gray-800 hover:text-[#FF9D37] font-medium">
                    Contact aanmaken
                    <span class="ml-2 w-2.5 h-2.5 bg-[#FF9D37] rounded-full inline-block align-middle"></span>
                </a>
            </div>
        </div>

        <!-- Dropdown Menu Section (Positioned below the navbar) -->
        <div
            v-show="activeDropdown === 'leveranciersDropdown'"
            class="fixed rounded-2xl left-1/2 transform -translate-x-1/2 top-16 mt-16 bg-white border border-gray-200 shadow-xl px-6 py-8 max-w-6xl w-full z-40 transition-all duration-300 opacity-0"
            :class="{ 'opacity-100 translate-y-0': activeDropdown === 'leveranciersDropdown', 'translate-y-5': activeDropdown !== 'leveranciersDropdown' }"
            @mouseenter="setActiveDropdown('leveranciersDropdown')"
            @mouseleave="hideDropdownWithDelay"
        >
            <div class="flex justify-around gap-x-4">
                <a :href="route('leverancier.index')" class="text-gray-800 hover:text-[#FF9D37] font-medium">
                    Leverancierslijst
                    <span class="ml-2 w-2.5 h-2.5 bg-[#FF9D37] rounded-full inline-block align-middle"></span>
                </a>
                <a :href="route('leverancier.create')" class="text-gray-800 hover:text-[#FF9D37] font-medium">
                    Leverancier aanmaken
                    <span class="ml-2 w-2.5 h-2.5 bg-[#FF9D37] rounded-full inline-block align-middle"></span>
                </a>
                <a href="/leverancier/kaart" class="text-gray-800 hover:text-[#FF9D37] font-medium">
                    Leveranciers kaart
                    <span class="ml-2 w-2.5 h-2.5 bg-[#FF9D37] rounded-full inline-block align-middle"></span>
                </a>
                <a href="/leverancier/statistieken" class="text-gray-800 hover:text-[#FF9D37] font-medium">
                    Leverancier statistieken
                    <span class="ml-2 w-2.5 h-2.5 bg-[#FF9D37] rounded-full inline-block align-middle"></span>
                </a>
            </div>
        </div>



        <!-- Mobile Sidebar Menu with Click Dropdown -->
        <transition name="slide-right">
            <div v-if="sidebarOpen" class="fixed top-0 right-0 w-72 h-full bg-[#261D54] shadow-lg z-50 transform transition-transform duration-300">
                <div class="p-4 flex justify-between items-center border-b border-gray-200">
                    <button class="text-white focus:outline-none" @click="toggleSidebar">
                        <i class="fa-solid fa-times text-2xl"></i>
                    </button>
                </div>

                <nav class="p-4 space-y-4">
                    <!-- Home Link -->
                    <a href="/" class="block text-white hover:text-[#FF9D37] font-semibold">
                        <i class="fa-solid fa-house mr-2"></i> Home
                    </a>
                    <!-- Referrals Link -->
                    <a href="/referral" class="block text-white hover:text-[#FF9D37] font-semibold">
                        <i class="fa-solid fa-users mr-2"></i> Referrals
                    </a>

                    <!-- Klanten Dropdown -->
                    <div>
                        <button
                            @click="toggleDropdown('klant')"
                            class="block text-white hover:text-[#FF9D37] font-semibold w-full text-left flex items-center"
                        >
                            <i class="fa-solid fa-users mr-2"></i> Klanten
                            <i :class="dropdowns.klant ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down'" class="ml-auto"></i>
                        </button>
                        <div v-if="dropdowns.klant" class="ml-4 space-y-2 mt-2">
                            <a :href="route('klant.index')" class="block text-white hover:text-[#FF9D37] font-semibold">
                                <i class="fa-solid fa-list mr-2"></i> Klantenlijst
                            </a>
                            <a :href="route('klant.create')" class="block text-white hover:text-[#FF9D37] font-semibold">
                                <i class="fa-solid fa-plus mr-2"></i> Klant aanmaken
                            </a>
                            <a href="/klant/kaart" class="block text-white hover:text-[#FF9D37] font-semibold">
                                <i class="fa-solid fa-map-marker-alt mr-2"></i> Klanten kaart
                            </a>
                            <a href="/klant/statistieken" class="block text-white hover:text-[#FF9D37] font-semibold">
                                <i class="fa-solid fa-chart-line mr-2"></i> Klant statistieken
                            </a>
                        </div>
                    </div>

                    <!-- Contacten Dropdown -->
                    <div>
                        <button
                            @click="toggleDropdown('contact')"
                            class="block text-white hover:text-[#FF9D37] font-semibold w-full text-left flex items-center"
                        >
                            <i class="fa-solid fa-address-book mr-2"></i> Contacten
                            <i :class="dropdowns.contact ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down'" class="ml-auto"></i>
                        </button>
                        <div v-if="dropdowns.contact" class="ml-4 space-y-2 mt-2">
                            <a :href="route('contact.index')" class="block text-white hover:text-[#FF9D37] font-semibold">
                                <i class="fa-solid fa-list mr-2"></i> Contactenlijst
                            </a>
                            <a :href="route('contact.create')" class="block text-white hover:text-[#FF9D37] font-semibold">
                                <i class="fa-solid fa-plus mr-2"></i> Contact aanmaken
                            </a>
                        </div>
                    </div>

                    <!-- Leveranciers Dropdown -->
                    <div>
                        <button
                            @click="toggleDropdown('leverancier')"
                            class="block text-white hover:text-[#FF9D37] font-semibold w-full text-left flex items-center"
                        >
                            <i class="fa-solid fa-truck mr-2"></i> Leveranciers
                            <i :class="dropdowns.leverancier ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down'" class="ml-auto"></i>
                        </button>
                        <div v-if="dropdowns.leverancier" class="ml-4 space-y-2 mt-2">
                            <a :href="route('leverancier.index')" class="block text-white hover:text-[#FF9D37] font-semibold">
                                <i class="fa-solid fa-list mr-2"></i> Leverancierslijst
                            </a>
                            <a :href="route('leverancier.create')" class="block text-white hover:text-[#FF9D37] font-semibold">
                                <i class="fa-solid fa-plus mr-2"></i> Leverancier aanmaken
                            </a>
                        </div>
                    </div>

                    <!-- Gebruiker Link -->
                    <a href="/gebruiker" class="block text-white hover:text-[#FF9D37] font-semibold">
                        <i class="fa-solid fa-user mr-2"></i> Gebruikers
                    </a>

                    <!-- Logout or Login Button -->
                    <div class="mt-6">
                        <button
                            v-if="user"
                            @click.prevent="logout"
                            class="w-full font-bold bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-3 rounded-full flex items-center justify-center hover:bg-blue-600"
                        >
                            <span>Logout</span>
                            <i class="ml-2 fa-solid fa-right-from-bracket"></i>
                        </button>
                        <button
                            v-else
                            @click="redirectToLogin"
                            class="w-full font-bold bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-3 rounded-full flex items-center justify-center hover:bg-blue-600"
                        >
                            Login
                        </button>
                    </div>
                </nav>
            </div>
        </transition>

    </div>
</template>

<script setup>
import {Link, router, usePage} from "@inertiajs/vue3";
import {ref, computed, onUnmounted} from "vue";

// Get the current user data from the page props
const page = usePage();
const user = computed(() => page.props.user);

// Track which dropdown is currently active
const sidebarOpen = ref(false);

// Function to toggle the sidebar menu
const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

// Track which dropdown is currently active
const activeDropdown = ref(null);

// Timer to delay closing of the dropdown
let hoverTimer = null;

// Function to set the active dropdown when hovering over it
const setActiveDropdown = (dropdownName) => {
    if (hoverTimer) clearTimeout(hoverTimer); // Clear any existing timer
    activeDropdown.value = dropdownName;
};

// Function to hide the active dropdown after a delay
const hideDropdownWithDelay = () => {
    hoverTimer = setTimeout(() => {
        activeDropdown.value = null;
    }, 200); // 200ms delay before closing
};

// Function to redirect the user to the login page
const redirectToLogin = () => {
    router.visit(route('login')); // Adjust the route as needed
};

// Track the state of the user dropdown
const userDropdownOpen = ref(false);

// Function to toggle the visibility of the user dropdown for mobile
const toggleUserDropdown = () => {
    userDropdownOpen.value = !userDropdownOpen.value;
};

// Close the dropdown when clicking outside
const handleClickOutside = (event) => {
    if (!event.target.closest(".relative")) {
        userDropdownOpen.value = false;
    }
};

// Attach the event listener
document.addEventListener("click", handleClickOutside);

// Cleanup the event listener when component unmounts
onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});

// Function to handle logout
const logout = () => {
    // Use Inertia's visit method to perform a logout request
    router.delete(route('logout'));
};

// Track the dropdown state for the mobile version
const dropdowns = ref({
    klant: false,
    contact: false,
    leverancier: false,
});

// Function to toggle the mobile dropdown menu
const toggleDropdown = (dropdownName) => {
    dropdowns.value[dropdownName] = !dropdowns.value[dropdownName];
};
</script>


<style scoped>
/* Sidebar Slide Transition */
.slide-right-enter-active,
.slide-right-leave-active {
    transition: transform 0.3s ease;
}
.slide-right-enter-from {
    transform: translateX(100%);
}
.slide-right-leave-to {
    transform: translateX(100%);
}
</style>
