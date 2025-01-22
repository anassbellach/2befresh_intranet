<template>
    <div class="p-8 max-w-6xl mx-auto bg-white shadow-lg rounded-2xl mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Leverancier Details</h1>
            <Link
                :href="route('leverancier.index')"
                class="inline-flex items-center gap-2 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Terug naar Leveranciers
            </Link>
        </div>

        <table class="w-full border-collapse">
            <tbody>
            <tr class="bg-gray-50">
                <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">Bedrijfsnaam</td>
                <td class="py-4 text-sm text-gray-800">{{ leverancier.leverancier_bedrijfsnaam }}</td>
            </tr>
            <tr>
                <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">E-mailadres</td>
                <td class="py-4 text-sm text-gray-800">{{ leverancier.leverancier_email }}</td>
            </tr>
            <tr class="bg-gray-50">
                <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">Telefoonnummer</td>
                <td class="py-4 text-sm text-gray-800">{{ leverancier.leverancier_telefoon }}</td>
            </tr>
            <tr>
                <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">Adres</td>
                <td class="py-4 text-sm text-gray-800">{{ leverancier.leverancier_adres }}</td>
            </tr>
            <tr class="bg-gray-50">
                <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">Postcode</td>
                <td class="py-4 text-sm text-gray-800">{{ leverancier.leverancier_postcode }}</td>
            </tr>
            <tr>
                <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">Plaats</td>
                <td class="py-4 text-sm text-gray-800">{{ leverancier.leverancier_plaats }}</td>
            </tr>
            <tr class="bg-gray-50">
                <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">Land</td>
                <td class="py-4 text-sm text-gray-800">{{ leverancier.leverancier_land }}</td>
            </tr>
            <tr>
                <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">Leverancier Sinds</td>
                <td class="py-4 text-sm text-gray-800">{{ leverancier.leverancier_sinds }}</td>
            </tr>
            <tr class="bg-gray-50">
                <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">Actief</td>
                <td class="py-4">
                    <span :class="leverancier.leverancier_actief ? 'text-green-500 font-bold' : 'text-red-500 font-bold'">
                        {{ leverancier.leverancier_actief ? 'Actief' : 'Inactief' }}
                    </span>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="flex justify-end mt-6">
            <Link
                :href="route('leverancier.edit', { leverancier: leverancier.leverancier_id })"
                class="w-full text-center bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all"
            >
                Bewerk Leverancier
            </Link>
        </div>
    </div>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    leverancier: Object,
});
</script>
