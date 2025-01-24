<template>
    <div class="px-4">
        <div class="p-4 sm:p-8 max-w-6xl mx-auto bg-white shadow-lg rounded-2xl mb-8">

            <div class="flex justify-between items-center mb-6">
                <!-- Title and Back Button -->
                <div class="flex items-center justify-between w-full">
                    <!-- Title -->
                    <h1 class="text-xl sm:text-3xl font-semibold text-gray-800">Klant Bewerken</h1>

                    <!-- Back Button -->
                    <Link
                        :href="route('klant.index')"
                        class="inline-flex items-center justify-center w-10 h-10 bg-gray-200 text-gray-700 rounded-full shadow hover:bg-gray-300 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </Link>
                </div>
            </div>

            <form @submit.prevent="update">
                <!-- Using grid instead of table -->
                <div class="grid grid-cols-1 gap-6">
                    <!-- Bedrijfsnaam -->
                    <div class="flex flex-col">
                        <label for="klant_bedrijfsnaam" class="text-sm font-medium text-gray-700">
                            Bedrijfsnaam <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.klant_bedrijfsnaam"
                            type="text"
                            id="klant_bedrijfsnaam"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_bedrijfsnaam" class="text-red-500 text-sm">{{ form.errors.klant_bedrijfsnaam }}</span>
                    </div>

                    <!-- KVK-nummer -->
                    <div class="flex flex-col">
                        <label for="klant_kvk" class="text-sm font-medium text-gray-700">
                            KVK-nummer <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.klant_kvk"
                            type="text"
                            id="klant_kvk"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_kvk" class="text-red-500 text-sm">{{ form.errors.klant_kvk }}</span>
                    </div>

                    <!-- Factuur e-mailadres -->
                    <div class="flex flex-col">
                        <label for="klant_mail" class="text-sm font-medium text-gray-700">
                            Factuur e-mailadres <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.klant_mail"
                            type="email"
                            id="klant_mail"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_mail" class="text-red-500 text-sm">{{ form.errors.klant_mail }}</span>
                    </div>

                    <!-- Algemeen Telefoonnummer -->
                    <div class="flex flex-col">
                        <label for="klant_telefoon" class="text-sm font-medium text-gray-700">
                            Algemeen Telefoonnummer <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.klant_telefoon"
                            type="text"
                            id="klant_telefoon"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_telefoon" class="text-red-500 text-sm">{{ form.errors.klant_telefoon }}</span>
                    </div>

                    <!-- Adres -->
                    <div class="flex flex-col">
                        <label for="klant_adres" class="text-sm font-medium text-gray-700">
                            Adres <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.klant_adres"
                            type="text"
                            id="klant_adres"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_adres" class="text-red-500 text-sm">{{ form.errors.klant_adres }}</span>
                    </div>

                    <!-- Postcode -->
                    <div class="flex flex-col">
                        <label for="klant_postcode" class="text-sm font-medium text-gray-700">
                            Postcode <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.klant_postcode"
                            type="text"
                            id="klant_postcode"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_postcode" class="text-red-500 text-sm">{{ form.errors.klant_postcode }}</span>
                    </div>

                    <!-- Plaats -->
                    <div class="flex flex-col">
                        <label for="klant_plaats" class="text-sm font-medium text-gray-700">
                            Plaats <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.klant_plaats"
                            type="text"
                            id="klant_plaats"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_plaats" class="text-red-500 text-sm">{{ form.errors.klant_plaats }}</span>
                    </div>

                    <!-- Land -->
                    <div class="flex flex-col">
                        <label for="klant_land" class="text-sm font-medium text-gray-700">
                            Land <span class="text-red-500">*</span>
                        </label>
                        <select
                            v-model="form.klant_land"
                            id="klant_land"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        >
                            <option v-for="country in countries" :key="country" :value="country">
                                {{ country }}
                            </option>
                        </select>
                        <span v-if="form.errors.klant_land" class="text-red-500 text-sm">{{ form.errors.klant_land }}</span>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all"
                    >
                        Klant Bijwerken
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>



<script setup>
import { ref, onMounted } from 'vue';
import { Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    klant: Object,
});

const form = useForm({
    klant_bedrijfsnaam: props.klant.klant_bedrijfsnaam,
    klant_kvk: props.klant.klant_kvk,
    klant_mail: props.klant.klant_mail,
    klant_telefoon: props.klant.klant_telefoon,
    klant_adres: props.klant.klant_adres,
    klant_postcode: props.klant.klant_postcode,
    klant_plaats: props.klant.klant_plaats,
    klant_land: props.klant.klant_land,
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

const update = () => {
    form.put(route("klant.update", props.klant.klant_id));
};
</script>
