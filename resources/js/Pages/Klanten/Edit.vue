<template>
    <div class="p-8 max-w-4xl mx-auto bg-white shadow-lg rounded-2xl mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Bewerk Klant</h1>
            <Link
                :href="route('klant.index')"
                class="inline-flex items-center gap-2 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Terug naar Klanten
            </Link>
        </div>

        <form @submit.prevent="update">
            <table class="w-full border-collapse">
                <tbody>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="klant_bedrijfsnaam" class="block text-sm font-medium text-gray-700">Bedrijfsnaam</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.klant_bedrijfsnaam"
                            type="text"
                            id="klant_bedrijfsnaam"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_bedrijfsnaam" class="text-red-500 text-sm">{{ form.errors.klant_bedrijfsnaam }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="klant_kvk" class="block text-sm font-medium text-gray-700">KVK-nummer</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.klant_kvk"
                            type="text"
                            id="klant_kvk"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_kvk" class="text-red-500 text-sm">{{ form.errors.klant_kvk }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="klant_mail" class="block text-sm font-medium text-gray-700">Factuur e-mailadres</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.klant_mail"
                            type="email"
                            id="klant_mail"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_mail" class="text-red-500 text-sm">{{ form.errors.klant_mail }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="klant_telefoon" class="block text-sm font-medium text-gray-700">Algemeen Telefoonnummer</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.klant_telefoon"
                            type="text"
                            id="klant_telefoon"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_telefoon" class="text-red-500 text-sm">{{ form.errors.klant_telefoon }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="klant_adres" class="block text-sm font-medium text-gray-700">Adres</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.klant_adres"
                            type="text"
                            id="klant_adres"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_adres" class="text-red-500 text-sm">{{ form.errors.klant_adres }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="klant_postcode" class="block text-sm font-medium text-gray-700">Postcode</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.klant_postcode"
                            type="text"
                            id="klant_postcode"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_postcode" class="text-red-500 text-sm">{{ form.errors.klant_postcode }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="klant_plaats" class="block text-sm font-medium text-gray-700">Plaats</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.klant_plaats"
                            type="text"
                            id="klant_plaats"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.klant_plaats" class="text-red-500 text-sm">{{ form.errors.klant_plaats }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="klant_land" class="block text-sm font-medium text-gray-700">Land</label>
                    </td>
                    <td class="py-2">
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
                    </td>
                </tr>
<!--                <tr>-->
<!--                    <td class="py-2 pr-4">-->
<!--                        <label for="klant_actief" class="block text-sm font-medium text-gray-700">Status</label>-->
<!--                    </td>-->
<!--                    <td class="py-2">-->
<!--                        <select-->
<!--                            v-model="form.klant_actief"-->
<!--                            id="klant_actief"-->
<!--                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"-->
<!--                            required-->
<!--                        >-->
<!--                            <option value="1">Actief</option>-->
<!--                            <option value="0">Inactief</option>-->
<!--                        </select>-->
<!--                        <span v-if="form.errors.klant_actief" class="text-red-500 text-sm">{{ form.errors.klant_actief }}</span>-->
<!--                    </td>-->
<!--                </tr>-->
                </tbody>
            </table>

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
