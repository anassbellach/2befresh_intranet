<template>
    <div class="p-8 max-w-4xl mx-auto bg-white shadow-lg rounded-2xl mb-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Gebruiker Bewerken</h1>
            <Link
                :href="route('gebruiker.index')"
                class="inline-flex items-center gap-2 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Terug naar Gebruikers
            </Link>
        </div>

        <!-- Formulier -->
        <form @submit.prevent="update">
            <table class="w-full border-collapse">
                <tbody>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="user_firstname" class="block text-sm font-medium text-gray-700">Voornaam</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.user_firstname"
                            type="text"
                            id="user_firstname"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.user_firstname" class="text-red-500 text-sm">{{ form.errors.user_firstname }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="user_lastname" class="block text-sm font-medium text-gray-700">Achternaam</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.user_lastname"
                            type="text"
                            id="user_lastname"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.user_lastname" class="text-red-500 text-sm">{{ form.errors.user_lastname }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="user_email" class="block text-sm font-medium text-gray-700">E-mailadres</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.email"
                            type="email"
                            id="user_email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="user_rol" class="block text-sm font-medium text-gray-700">Rol</label>
                    </td>
                    <td class="py-2">
                        <select
                            v-model="form.user_rol"
                            id="user_rol"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <option value="Directie">Directie</option>
                            <option value="Manager">Manager</option>
                            <option value="Werknemer">Werknemer</option>
                        </select>
                        <span v-if="form.errors.user_rol" class="text-red-500 text-sm">{{ form.errors.user_rol }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Wachtwoord</label>
                    </td>
                    <td class="py-2 relative">
                        <input
                            v-model="form.password"
                            :type="passwordVisible ? 'text' : 'password'"
                            id="password"
                            placeholder="Vul je wachtwoord in"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <button
                            type="button"
                            @click="togglePasswordVisibility"
                            class="absolute right-3 top-3 text-gray-500 hover:text-gray-800"
                        >
                            <template v-if="passwordVisible">
                                <i class="fas fa-eye"></i>
                            </template>
                            <template v-else>
                                <i class="fas fa-eye-slash"></i>
                            </template>
                        </button>
                        <span v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</span>
                    </td>
                </tr>
<!--                <tr>-->
<!--                    <td class="py-2 pr-4">-->
<!--                        <label for="user_activated" class="block text-sm font-medium text-gray-700">Activatiestatus</label>-->
<!--                    </td>-->
<!--                    <td class="py-2">-->
<!--                        <select-->
<!--                            v-model="form.user_activated"-->
<!--                            id="user_activated"-->
<!--                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"-->
<!--                        >-->
<!--                            <option :value="1">Actief</option>-->
<!--                            <option :value="0">Inactief</option>-->
<!--                        </select>-->
<!--                        <span v-if="form.errors.user_activated" class="text-red-500 text-sm">{{ form.errors.user_activated }}</span>-->
<!--                    </td>-->
<!--                </tr>-->
                </tbody>
            </table>

            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-l"
                >
                    Gebruiker Bijwerken
                </button>
            </div>
        </form>
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
