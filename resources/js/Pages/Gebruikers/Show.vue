<template>
    <div class="p-8 max-w-6xl mx-auto bg-white shadow-lg rounded-2xl mb-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Gebruikersdetails</h1>
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

        <!-- Details Tabel -->
        <table class="w-full border-collapse">
            <tbody>
            <tr class="bg-gray-50">
                <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">Voornaam</td>
                <td class="py-4 text-sm text-gray-800">{{ gebruiker.user_firstname }}</td>
            </tr>
            <tr>
                <td class="py-4 pr-6 text-sm font-medium text-gray-600">Achternaam</td>
                <td class="py-4 text-sm text-gray-800">{{ gebruiker.user_lastname }}</td>
            </tr>
            <tr class="bg-gray-50">
                <td class="py-4 pr-6 text-sm font-medium text-gray-600">E-mailadres</td>
                <td class="py-4 text-sm text-gray-800">{{ gebruiker.email }}</td>
            </tr>
            <tr>
                <td class="py-4 pr-6 text-sm font-medium text-gray-600">Rol</td>
                <td class="py-4 text-sm text-gray-800">{{ gebruiker.user_rol }}</td>
            </tr>
            <tr class="bg-gray-50">
                <td class="py-4 pr-6 text-sm font-medium text-gray-600">Activatiestatus</td>
                <td class="py-4">
                        <span :class="[
                            gebruiker.user_activated
                                ? 'text-green-800 bg-green-100 px-2 py-1 text-sm font-medium rounded-full'
                                : 'text-red-800 bg-red-100 px-2 py-1 text-sm font-medium rounded-full'
                        ]">
                            {{ gebruiker.user_activated ? 'Actief' : 'Inactief' }}
                        </span>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Actieknoppen -->
        <div class="flex justify-end mt-6">
            <Link
                :href="route('gebruiker.edit', gebruiker.user_id)"
                class="w-full text-center bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-l"
            >
                Bewerk Gebruiker
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    gebruiker: Object,
});
</script>
