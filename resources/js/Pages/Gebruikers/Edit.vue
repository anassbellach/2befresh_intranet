<template>
    <div class="px-4">
        <div class="p-4 sm:p-8 max-w-6xl mx-auto bg-white shadow-lg rounded-2xl mb-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <!-- Title and Back Button -->
                <div class="flex items-center justify-between w-full">
                    <!-- Title -->
                    <h1 class="text-xl sm:text-3xl font-semibold text-gray-800">Gebruiker Bewerken</h1>

                    <!-- Back Button -->
                    <Link
                        :href="route('gebruiker.index')"
                        class="inline-flex items-center justify-center w-10 h-10 bg-gray-200 text-gray-700 rounded-full shadow hover:bg-gray-300 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </Link>
                </div>
            </div>

            <!-- Formulier -->
            <form @submit.prevent="update">
                <!-- Using grid layout for form fields -->
                <div class="grid grid-cols-1 gap-6">
                    <!-- Voornaam -->
                    <div class="flex flex-col">
                        <label for="user_firstname" class="text-sm font-medium text-gray-700">Voornaam <span class="text-red-500">*</span></label>
                        <input
                            v-model="form.user_firstname"
                            type="text"
                            id="user_firstname"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.user_firstname" class="text-red-500 text-sm">{{ form.errors.user_firstname }}</span>
                    </div>

                    <!-- Achternaam -->
                    <div class="flex flex-col">
                        <label for="user_lastname" class="text-sm font-medium text-gray-700">Achternaam <span class="text-red-500">*</span></label>
                        <input
                            v-model="form.user_lastname"
                            type="text"
                            id="user_lastname"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.user_lastname" class="text-red-500 text-sm">{{ form.errors.user_lastname }}</span>
                    </div>

                    <!-- E-mailadres -->
                    <div class="flex flex-col">
                        <label for="user_email" class="text-sm font-medium text-gray-700">E-mailadres <span class="text-red-500">*</span></label>
                        <input
                            v-model="form.email"
                            type="email"
                            id="user_email"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                    </div>

                    <!-- Rol -->
                    <div class="flex flex-col">
                        <label for="user_rol" class="text-sm font-medium text-gray-700">Rol <span class="text-red-500">*</span></label>
                        <select
                            v-model="form.user_rol"
                            id="user_rol"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <option value="Directie">Directie</option>
                            <option value="Manager">Manager</option>
                            <option value="Werknemer">Werknemer</option>
                        </select>
                        <span v-if="form.errors.user_rol" class="text-red-500 text-sm">{{ form.errors.user_rol }}</span>
                    </div>

                    <!-- Wachtwoord -->
                    <div class="flex flex-col relative">
                        <label for="password" class="text-sm font-medium text-gray-700">Wachtwoord <span class="text-gray-500">(Optioneel)</span></label>
                        <div class="relative">
                            <input
                                v-model="form.password"
                                :type="passwordVisible ? 'text' : 'password'"
                                id="password"
                                placeholder="Vul je wachtwoord in (optioneel)"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            />
                            <!-- Password visibility toggle -->
                            <button
                                type="button"
                                @click="togglePasswordVisibility"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-800 focus:outline-none"
                            >
                                <template v-if="passwordVisible">
                                    <i class="fas fa-eye"></i>
                                </template>
                                <template v-else>
                                    <i class="fas fa-eye-slash"></i>
                                </template>
                            </button>
                        </div>
                        <span v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</span>
                    </div>

                </div>

                <div class="flex justify-end mt-6">
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all"
                    >
                        Gebruiker Bijwerken
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>


<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    gebruiker: Object,
});

const form = useForm({
    user_firstname: props.gebruiker.user_firstname,
    user_lastname: props.gebruiker.user_lastname,
    email: props.gebruiker.email,
    password: '',
    user_activated: props.gebruiker.user_activated,
    user_rol: props.gebruiker.user_rol,
});

const passwordVisible = ref(false);
const togglePasswordVisibility = () => {
    passwordVisible.value = !passwordVisible.value;
};

const update = () => {
    form.put(route('gebruiker.update', props.gebruiker.user_id));
};
</script>
