<template>
    <div class="bg-[#FCFCFC] min-h-screen relative overflow-hidden">
        <div class="absolute top-[-520px] left-[-500px] bg-gradient-to-br from-pink-500 via-red-500 to-orange-500 rounded-full opacity-90 overflow-hidden" style="width: 750px; height: 750px;">
            <img src="https://www.2befresh.nl/wp-content/uploads/2022/08/Screenshot-2022-08-31-at-10.33.34.png" alt="Links Boven Afbeelding" class="w-full h-full opacity-40 object-cover">
        </div>

        <div class="absolute top-[-380px] right-[-350px] bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 rounded-full opacity-90 overflow-hidden" style="width: 750px; height: 750px;">
            <img src="https://www.2befresh.nl/wp-content/uploads/2023/01/Marketingbureau-2BeFresh.jpg" alt="Rechts Boven Afbeelding" class="w-full h-full opacity-10 object-cover">
        </div>
        <div class="px-4">
            <div class="relative flex items-center justify-center min-h-screen z-10">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-8 space-y-6">
                    <div class="text-center">
                        <img
                            src="https://www.2befresh.nl/wp-content/uploads/2022/11/cropped-2BeFresh-favicon-270x270.png"
                            alt="2BeFresh Logo"
                            class="w-32 mx-auto mb-6 rounded-lg"
                        />
                        <h1 class="text-4xl font-semibold text-gray-800 mb-2">Welkom Terug</h1>
                        <p class="text-sm text-gray-500 mb-6">Log in op je account</p>
                    </div>

                    <form @submit.prevent="login">
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">E-mailadres</label>
                            <input
                                v-model="form.email"
                                type="email"
                                id="email"
                                placeholder="Vul je e-mailadres in"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            />
                            <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                        </div>

                        <div class="mb-6 relative">
                            <label for="password" class="block text-sm font-medium text-gray-700">Wachtwoord</label>

                            <input
                                v-model="form.password"
                                :type="passwordVisible ? 'text' : 'password'"
                                id="password"
                                placeholder="Vul je wachtwoord in"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            />

                            <button
                                type="button"
                                @click="togglePasswordVisibility"
                                class="absolute right-3 top-9 text-gray-500 hover:text-gray-800"
                            >
                                <template v-if="passwordVisible">
                                    <i class="fas fa-eye"></i>
                                </template>

                                <template v-else-if="!passwordVisible">
                                    <i class="fas fa-eye-slash"></i>
                                </template>
                            </button>

                            <span v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</span>
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all"
                        >
                            Inloggen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const form = useForm({
    email: null,
    password: null,
});

const passwordVisible = ref(false);

const togglePasswordVisibility = () => {
    passwordVisible.value = !passwordVisible.value;
};

const login = () => {
    form.post(route("login"));
};
</script>

<script>
export default {
    layout: null,
};
</script>
