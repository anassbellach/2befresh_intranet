<template>
    <div class="p-8 max-w-4xl mx-auto bg-white shadow-lg rounded-2xl mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Nieuwe Leverancier Aanmaken</h1>
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

        <form @submit.prevent="create">
            <table class="w-full border-collapse">
                <tbody>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="leverancier_bedrijfsnaam" class="block text-sm font-medium text-gray-700">Bedrijfsnaam</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.leverancier_bedrijfsnaam"
                            type="text"
                            id="leverancier_bedrijfsnaam"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.leverancier_bedrijfsnaam" class="text-red-500 text-sm">{{ form.errors.leverancier_bedrijfsnaam }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="leverancier_email" class="block text-sm font-medium text-gray-700">E-mailadres</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.leverancier_email"
                            type="email"
                            id="leverancier_email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.leverancier_email" class="text-red-500 text-sm">{{ form.errors.leverancier_email }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="leverancier_telefoon" class="block text-sm font-medium text-gray-700">Telefoonnummer</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.leverancier_telefoon"
                            type="text"
                            id="leverancier_telefoon"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.leverancier_telefoon" class="text-red-500 text-sm">{{ form.errors.leverancier_telefoon }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="leverancier_adres" class="block text-sm font-medium text-gray-700">Adres</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.leverancier_adres"
                            type="text"
                            id="leverancier_adres"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.leverancier_adres" class="text-red-500 text-sm">{{ form.errors.leverancier_adres }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="leverancier_postcode" class="block text-sm font-medium text-gray-700">Postcode</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.leverancier_postcode"
                            type="text"
                            id="leverancier_postcode"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.leverancier_postcode" class="text-red-500 text-sm">{{ form.errors.leverancier_postcode }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="leverancier_plaats" class="block text-sm font-medium text-gray-700">Plaats</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.leverancier_plaats"
                            type="text"
                            id="leverancier_plaats"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.leverancier_plaats" class="text-red-500 text-sm">{{ form.errors.leverancier_plaats }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="leverancier_land" class="block text-sm font-medium text-gray-700">Land</label>
                    </td>
                    <td class="py-2">
                        <select
                            v-model="form.leverancier_land"
                            id="leverancier_land"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <option value="" disabled>Selecteer een land</option>
                            <option v-for="country in countries" :key="country" :value="country">
                                {{ country }}
                            </option>
                        </select>
                        <span v-if="form.errors.leverancier_land" class="text-red-500 text-sm">{{ form.errors.leverancier_land }}</span>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-l"
                >
                    Leverancier Aanmaken
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

const form = useForm({
    leverancier_bedrijfsnaam: '',
    leverancier_email: '',
    leverancier_telefoon: '',
    leverancier_adres: '',
    leverancier_postcode: '',
    leverancier_plaats: '',
    leverancier_land: '',
});

const countries = ref([]);

onMounted(async () => {
    try {
        const response = await fetch('http://api.geonames.org/countryInfoJSON?username=anass990&lang=nl');
        const data = await response.json();
        countries.value = data.geonames.map((country) => country.countryName);
    } catch (error) {
        console.error('Fout bij het ophalen van landen:', error);
    }
});

const create = () => {
    form.post(route('leverancier.store'));
};
</script>
