<template>
    <div class="p-8 max-w-4xl mx-auto bg-white shadow-lg rounded-2xl mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Bewerk Leverancier</h1>
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

        <form @submit.prevent="update">
            <table class="w-full border-collapse">
                <tbody>
                <tr v-for="(label, key) in formFields" :key="key">
                    <td class="py-2 pr-4">
                        <label :for="key" class="block text-sm font-medium text-gray-700">{{ label }}</label>
                    </td>
                    <td class="py-2">
                        <component
                            :is="key === 'leverancier_actief' ? 'select' : 'input'"
                            v-model="form[key]"
                            :id="key"
                            :type="inputTypes[key] || 'text'"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            :step="inputTypes[key] === 'number' ? 'any' : null"
                            :required="requiredFields.includes(key)"
                        >
                            <option v-if="key === 'leverancier_actief'" value="1">Actief</option>
                            <option v-if="key === 'leverancier_actief'" value="0">Inactief</option>
                        </component>
                        <span v-if="form.errors[key]" class="text-red-500 text-sm">{{ form.errors[key] }}</span>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-l"
                >
                    Leverancier Bijwerken
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    leverancier: Object,
});

const formFields = {
    leverancier_bedrijfsnaam: "Bedrijfsnaam",
    leverancier_email: "E-mailadres",
    leverancier_telefoon: "Telefoonnummer",
    leverancier_adres: "Adres",
    leverancier_postcode: "Postcode",
    leverancier_plaats: "Plaats",
    leverancier_land: "Land",
    leverancier_latitude: "Breedtegraad",
    leverancier_longitude: "Lengtegraad",
    leverancier_sinds: "Leverancier Sinds",
    leverancier_actief: "Actief",
};

const inputTypes = {
    leverancier_email: "email",
    leverancier_latitude: "number",
    leverancier_longitude: "number",
    leverancier_sinds: "date",
};

const requiredFields = [
    "leverancier_bedrijfsnaam",
    "leverancier_email",
    "leverancier_telefoon",
    "leverancier_adres",
    "leverancier_postcode",
    "leverancier_plaats",
    "leverancier_land",
    "leverancier_sinds",
];

const form = useForm({
    leverancier_bedrijfsnaam: props.leverancier.leverancier_bedrijfsnaam,
    leverancier_email: props.leverancier.leverancier_email,
    leverancier_telefoon: props.leverancier.leverancier_telefoon,
    leverancier_adres: props.leverancier.leverancier_adres,
    leverancier_postcode: props.leverancier.leverancier_postcode,
    leverancier_plaats: props.leverancier.leverancier_plaats,
    leverancier_land: props.leverancier.leverancier_land,
    leverancier_latitude: props.leverancier.leverancier_latitude,
    leverancier_longitude: props.leverancier.leverancier_longitude,
    leverancier_sinds: props.leverancier.leverancier_sinds,
    leverancier_actief: props.leverancier.leverancier_actief ? "1" : "0",
});

const update = () => {
    form.put(route("leverancier.update", props.leverancier.leverancier_id));
};
</script>
