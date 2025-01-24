<template>
    <div class="px-4">
        <div class="p-8 max-w-6xl mx-auto bg-white shadow-lg rounded-2xl mb-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center justify-between w-full">
                    <h1 class="text-xl sm:text-3xl font-semibold text-gray-800">Leverancier aanmaken</h1>

                    <Link
                        :href="route('leverancier.index')"
                        class="inline-flex items-center justify-center w-10 h-10 bg-gray-200 text-gray-700 rounded-full shadow hover:bg-gray-300 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </Link>
                </div>
            </div>

            <!-- Form -->
            <form @submit.prevent="create">
                <div class="grid grid-cols-1 gap-6">

                    <!-- Bedrijfsnaam -->
                    <div class="flex flex-col">
                        <label for="leverancier_bedrijfsnaam" class="text-sm font-medium text-gray-700">
                            Bedrijfsnaam <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.leverancier_bedrijfsnaam"
                            type="text"
                            id="leverancier_bedrijfsnaam"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.leverancier_bedrijfsnaam" class="text-red-500 text-sm">{{ form.errors.leverancier_bedrijfsnaam }}</span>
                    </div>

                    <!-- E-mailadres -->
                    <div class="flex flex-col">
                        <label for="leverancier_email" class="text-sm font-medium text-gray-700">
                            E-mailadres <span class="text-gray-500 text-xs italic">(Optioneel)</span>
                        </label>
                        <input
                            v-model="form.leverancier_email"
                            type="email"
                            id="leverancier_email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.leverancier_email" class="text-red-500 text-sm">{{ form.errors.leverancier_email }}</span>
                    </div>

                    <!-- Telefoonnummer -->
                    <div class="flex flex-col">
                        <label for="leverancier_telefoon" class="text-sm font-medium text-gray-700">
                            Telefoonnummer <span class="text-gray-500 text-xs italic">(Optioneel)</span>
                        </label>
                        <input
                            v-model="form.leverancier_telefoon"
                            type="text"
                            id="leverancier_telefoon"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.leverancier_telefoon" class="text-red-500 text-sm">{{ form.errors.leverancier_telefoon }}</span>
                    </div>

                    <!-- Adres -->
                    <div class="flex flex-col">
                        <label for="leverancier_adres" class="text-sm font-medium text-gray-700">
                            Adres <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.leverancier_adres"
                            type="text"
                            id="leverancier_adres"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.leverancier_adres" class="text-red-500 text-sm">{{ form.errors.leverancier_adres }}</span>
                    </div>

                    <!-- Postcode -->
                    <div class="flex flex-col">
                        <label for="leverancier_postcode" class="text-sm font-medium text-gray-700">
                            Postcode <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.leverancier_postcode"
                            type="text"
                            id="leverancier_postcode"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.leverancier_postcode" class="text-red-500 text-sm">{{ form.errors.leverancier_postcode }}</span>
                    </div>

                    <!-- Plaats -->
                    <div class="flex flex-col">
                        <label for="leverancier_plaats" class="text-sm font-medium text-gray-700">
                            Plaats <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.leverancier_plaats"
                            type="text"
                            id="leverancier_plaats"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.leverancier_plaats" class="text-red-500 text-sm">{{ form.errors.leverancier_plaats }}</span>
                    </div>

                    <!-- Land -->
                    <div class="flex flex-col">
                        <label for="leverancier_land" class="text-sm font-medium text-gray-700">
                            Land <span class="text-red-500">*</span>
                        </label>
                        <select
                            v-model="form.leverancier_land"
                            id="leverancier_land"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <option value="" disabled>Selecteer een land</option>
                            <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
                        </select>
                        <span v-if="form.errors.leverancier_land" class="text-red-500 text-sm">{{ form.errors.leverancier_land }}</span>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-6">
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all"
                    >
                        Leverancier Aanmaken
                    </button>
                </div>
            </form>
        </div>
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
    leverancier_actief: '1',
});

const countries = ref([]);

onMounted(async () => {
    try {
        const response = await fetch('https://secure.geonames.org/countryInfoJSON?username=anass990&lang=nl');
        const data = await response.json();
        countries.value = data.geonames.map(country => country.countryName);
    } catch (error) {
        console.error('Fout bij het ophalen van landen:', error);
    }
});

const create = () => {
    form.post(route('leverancier.store'));
};
</script>
