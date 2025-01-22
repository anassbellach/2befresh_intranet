<template>
    <div class="p-8 max-w-6xl mx-auto bg-white shadow-lg rounded-2xl mb-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Contact Bewerken</h1>
            <Link
                :href="route('contact.index')"
                class="inline-flex items-center gap-2 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Terug naar Contacten
            </Link>
        </div>

        <!-- Formulier -->
        <form @submit.prevent="update">
            <table class="w-full border-collapse">
                <tbody>
                <!-- Naam -->
                <tr>
                    <td class="py-2 pr-4">
                        <label for="contact_naam" class="block text-sm font-medium text-gray-700">
                            Naam <span class="text-red-500">*</span>
                        </label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.contact_naam"
                            type="text"
                            id="contact_naam"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.contact_naam" class="text-red-500 text-sm">{{ form.errors.contact_naam }}</span>
                    </td>
                </tr>

                <!-- Geboortedatum -->
                <tr>
                    <td class="py-2 pr-4">
                        <label for="contact_geboortedatum" class="block text-sm font-medium text-gray-700">
                            Geboortedatum <span class="text-gray-500 text-xs italic">(Optioneel)</span>
                        </label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.contact_geboortedatum"
                            type="date"
                            id="contact_geboortedatum"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.contact_geboortedatum" class="text-red-500 text-sm">{{ form.errors.contact_geboortedatum }}</span>
                    </td>
                </tr>

                <!-- Geslacht -->
                <tr>
                    <td class="py-2 pr-4">
                        <label for="contact_geslacht" class="block text-sm font-medium text-gray-700">
                            Geslacht <span class="text-gray-500 text-xs italic">(Optioneel)</span>
                        </label>
                    </td>
                    <td class="py-2">
                        <select
                            v-model="form.contact_geslacht"
                            id="contact_geslacht"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <option value="Man">Man</option>
                            <option value="Vrouw">Vrouw</option>
                            <option value="Anders">Anders</option>
                        </select>
                        <span v-if="form.errors.contact_geslacht" class="text-red-500 text-sm">{{ form.errors.contact_geslacht }}</span>
                    </td>
                </tr>

                <!-- Telefoonnummer -->
                <tr>
                    <td class="py-2 pr-4">
                        <label for="contact_telefoon" class="block text-sm font-medium text-gray-700">
                            Telefoonnummer <span class="text-red-500">*</span>
                        </label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.contact_telefoon"
                            type="text"
                            id="contact_telefoon"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.contact_telefoon" class="text-red-500 text-sm">{{ form.errors.contact_telefoon }}</span>
                    </td>
                </tr>

                <!-- Telefoonnummer Kantoor -->
                <tr>
                    <td class="py-2 pr-4">
                        <label for="contact_telefoon_kantoor" class="block text-sm font-medium text-gray-700">
                            Telefoonnummer (Kantoor) <span class="text-gray-500 text-xs italic">(Optioneel)</span>
                        </label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.contact_telefoon_kantoor"
                            type="text"
                            id="contact_telefoon_kantoor"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.contact_telefoon_kantoor" class="text-red-500 text-sm">{{ form.errors.contact_telefoon_kantoor }}</span>
                    </td>
                </tr>

                <!-- E-mailadres -->
                <tr>
                    <td class="py-2 pr-4">
                        <label for="contact_mail" class="block text-sm font-medium text-gray-700">
                            E-mailadres <span class="text-red-500">*</span>
                        </label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.contact_mail"
                            type="email"
                            id="contact_mail"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.contact_mail" class="text-red-500 text-sm">{{ form.errors.contact_mail }}</span>
                    </td>
                </tr>

                <!-- E-mailadres 2 -->
                <tr>
                    <td class="py-2 pr-4">
                        <label for="contact_mail_2" class="block text-sm font-medium text-gray-700">
                            E-mailadres 2 <span class="text-gray-500 text-xs italic">(Optioneel)</span>
                        </label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.contact_mail_2"
                            type="email"
                            id="contact_mail_2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.contact_mail_2" class="text-red-500 text-sm">{{ form.errors.contact_mail_2 }}</span>
                    </td>
                </tr>

                <!-- E-mailadres 3 -->
                <tr>
                    <td class="py-2 pr-4">
                        <label for="contact_mail_3" class="block text-sm font-medium text-gray-700">
                            E-mailadres 3 <span class="text-gray-500 text-xs italic">(Optioneel)</span>
                        </label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.contact_mail_3"
                            type="email"
                            id="contact_mail_3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.contact_mail_3" class="text-red-500 text-sm">{{ form.errors.contact_mail_3 }}</span>
                    </td>
                </tr>

                <!-- Contact Voorkeur -->
                <tr>
                    <td class="py-2 pr-4">
                        <label for="contact_voorkeur" class="block text-sm font-medium text-gray-700">
                            Contact voorkeur <span class="text-gray-500 text-xs italic">(Optioneel)</span>
                        </label>
                    </td>
                    <td class="py-2">
                        <select
                            v-model="form.contact_voorkeur"
                            id="contact_voorkeur"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <option value="Mail">Mail</option>
                            <option value="Mail 2">Mail 2</option>
                            <option value="Mail 3">Mail 3</option>
                            <option value="Telefoon">Telefoon</option>
                            <option value="Telefoon kantoor">Telefoon kantoor</option>
                            <option value="Geen voorkeur">Geen voorkeur</option>
                        </select>
                        <span v-if="form.errors.contact_voorkeur" class="text-red-500 text-sm">{{ form.errors.contact_voorkeur }}</span>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all"
                >
                    Contact Bijwerken
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    contact: Object,
});

const form = useForm({
    contact_naam: props.contact.contact_naam,
    contact_geboortedatum: props.contact.contact_geboortedatum,
    contact_geslacht: props.contact.contact_geslacht,
    contact_telefoon: props.contact.contact_telefoon,
    contact_telefoon_kantoor: props.contact.contact_telefoon_kantoor,
    contact_mail: props.contact.contact_mail,
    contact_mail_2: props.contact.contact_mail_2,
    contact_mail_3: props.contact.contact_mail_3,
    contact_voorkeur: props.contact.contact_voorkeur,
});

const update = () => {
    form.put(route('contact.update', { contact: props.contact.contact_id }));
};
</script>
