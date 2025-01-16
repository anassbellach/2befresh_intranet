<template>
    <div class="bg-[#FCFCFC] min-h-screen relative overflow-hidden">
        <!-- Gradiëntcirkel Linksboven -->
        <div class="absolute top-[-520px] left-[-500px] bg-gradient-to-br from-pink-500 via-red-500 to-orange-500 rounded-full opacity-90 overflow-hidden" style="width: 750px; height: 750px;">
            <img src="https://www.2befresh.nl/wp-content/uploads/2022/08/Screenshot-2022-08-31-at-10.33.34.png" alt="Linksboven Afbeelding" class="w-full h-full opacity-40 object-cover">
        </div>

        <!-- Gradiëntcirkel Rechtsboven met Afbeelding -->
        <div class="absolute top-[-380px] right-[-350px] bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 rounded-full opacity-90 overflow-hidden" style="width: 750px; height: 750px;">
            <img src="https://www.2befresh.nl/wp-content/uploads/2023/01/Marketingbureau-2BeFresh.jpg" alt="Rechtsboven Afbeelding" class="w-full h-full opacity-10 object-cover">
        </div>

        <div class="relative flex items-center justify-center min-h-screen z-10">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-8 space-y-6">
                <div class="text-center">
                    <img
                        src="https://www.2befresh.nl/wp-content/uploads/2022/11/cropped-2BeFresh-favicon-270x270.png"
                        alt="2BeFresh Logo"
                        class="w-32 mx-auto mb-6 rounded-lg"
                    />
                    <h1 class="text-4xl font-semibold text-gray-800 mb-2">Registreren</h1>
                    <p class="text-sm text-gray-500 mb-6">Maak een account aan</p>
                </div>

                <form @submit.prevent="register">
                    <div class="mb-4">
                        <label for="user_firstname" class="block text-sm font-medium text-gray-700">Voornaam</label>
                        <input
                            v-model="form.user_firstname"
                            type="text"
                            id="user_firstname"
                            placeholder="Voer je voornaam in"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.user_firstname" class="text-red-500 text-sm">{{ form.errors.user_firstname }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="user_lastname" class="block text-sm font-medium text-gray-700">Achternaam</label>
                        <input
                            v-model="form.user_lastname"
                            type="text"
                            id="user_lastname"
                            placeholder="Voer je achternaam in"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.user_lastname" class="text-red-500 text-sm">{{ form.errors.user_lastname }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">E-mailadres</label>
                        <input
                            v-model="form.email"
                            type="email"
                            id="email"
                            placeholder="Voer je e-mailadres in"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="user_rol" class="block text-sm font-medium text-gray-700">Rol</label>
                        <select
                            v-model="form.user_rol"
                            id="user_rol"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <option disabled value="">Selecteer een rol</option>
                            <option value="Directie">Directie</option>
                            <option value="Manager">Manager</option>
                            <option value="Werknemer">Werknemer</option>
                        </select>
                        <span v-if="form.errors.user_rol" class="text-red-500 text-sm">{{ form.errors.user_rol }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Wachtwoord</label>
                        <input
                            v-model="form.password"
                            type="password"
                            id="password"
                            placeholder="Voer je wachtwoord in"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Bevestig Wachtwoord</label>
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            id="password_confirmation"
                            placeholder="Bevestig je wachtwoord"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.password_confirmation" class="text-red-500 text-sm">{{ form.errors.password_confirmation }}</span>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-gradient-to-l transition duration-300"
                    >
                        Registreren
                    </button>
                </form>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500">Heb je al een account? <a :href="route('login')" class="text-indigo-600 hover:underline">Inloggen</a></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    user_firstname: '',
    user_lastname: '',
    email: '',
    password: '',
    password_confirmation: '',
    user_rol: '',
    user_activated: '1', // Standaard op actief
});

const register = () => {
    form.post(route('gebruiker.store')); // Zorg dat de backendroute overeenkomt met je registratie-endpoint
};
</script>

<script>
export default {
    layout: null, // Layout expliciet uitschakelen voor deze pagina
};
</script>
