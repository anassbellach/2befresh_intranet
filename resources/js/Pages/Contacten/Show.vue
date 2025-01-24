<template>
    <div class="px-4">
        <div class="p-8 max-w-6xl mx-auto bg-white shadow-lg rounded-2xl mb-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <!-- Title and Back Button -->
                <div class="flex items-center justify-between w-full">
                    <!-- Title -->
                    <h1 class="text-xl sm:text-3xl font-semibold text-gray-800">
                        Contact Details
                    </h1>

                    <!-- Back Button -->
                    <Link
                        :href="route('contact.index')"
                        class="inline-flex items-center justify-center w-10 h-10 bg-gray-200 text-gray-700 rounded-full shadow hover:bg-gray-300 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </Link>
                </div>
            </div>

            <!-- Responsive Table Wrapper -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <tbody>
                    <tr class="bg-gray-50">
                        <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">
                            Naam
                        </td>
                        <td class="py-4 text-sm text-gray-800">
                            {{ contact.contact_naam }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">
                            Geboortedatum
                        </td>
                        <td class="py-4 text-sm text-gray-800">
                            {{ contact.contact_geboortedatum }}
                        </td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">
                            Geslacht
                        </td>
                        <td class="py-4 text-sm text-gray-800 capitalize">
                            {{ contact.contact_geslacht }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">
                            Telefoonnummer
                        </td>
                        <td class="py-4 text-sm text-gray-800">
                            {{ contact.contact_telefoon || 'N.V.T.' }}
                        </td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">
                            Telefoonnummer (Kantoor)
                        </td>
                        <td class="py-4 text-sm text-gray-800">
                            {{ contact.contact_telefoon_kantoor || 'N.V.T.' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">
                            E-mailadres
                        </td>
                        <td class="py-4 text-sm text-gray-800">
                            {{ contact.contact_mail }}
                        </td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">
                            E-mailadres 2
                        </td>
                        <td class="py-4 text-sm text-gray-800">
                            {{ contact.contact_mail_2 || 'N.V.T.' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">
                            E-mailadres 3
                        </td>
                        <td class="py-4 text-sm text-gray-800">
                            {{ contact.contact_mail_3 || 'N.V.T.' }}
                        </td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">
                            Voorkeur
                        </td>
                        <td class="py-4 text-sm text-gray-800">
                            {{ contact.contact_voorkeur || 'N.V.T.' }}
                        </td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="py-4 pr-6 text-sm font-medium text-gray-600 w-1/3">
                            Actief
                        </td>
                        <td class="py-4">
                                <span :class="contact.contact_actief ? 'text-green-500 font-bold' : 'text-red-500 font-bold'">
                                    {{ contact.contact_actief ? 'Actief' : 'Inactief' }}
                                </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-6">
                <Link
                    :href="route('contact.edit', contact.contact_id)"
                    class="w-full text-center bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all"
                >
                    Bewerk Contact
                </Link>
            </div>
        </div>
    </div>
</template>


<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    contact: Object,
});
</script>
