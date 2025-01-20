<template>
    <div class="p-8 max-w-4xl mx-auto bg-white shadow-lg rounded-2xl mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Referral Bewerken</h1>
            <Link
                :href="route('referral.index')"
                class="inline-flex items-center gap-2 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Terug naar Referrals
            </Link>
        </div>

        <form @submit.prevent="update">
            <table class="w-full border-collapse">
                <tbody>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="titel" class="block text-sm font-medium text-gray-700">Titel</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.titel"
                            type="text"
                            id="titel"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.titel" class="text-red-500 text-sm">{{ form.errors.titel }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="omschrijving" class="block text-sm font-medium text-gray-700">Omschrijving</label>
                    </td>
                    <td class="py-2">
                            <textarea
                                v-model="form.omschrijving"
                                id="omschrijving"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            ></textarea>
                        <span v-if="form.errors.omschrijving" class="text-red-500 text-sm">{{ form.errors.omschrijving }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-4">
                        <label for="link" class="block text-sm font-medium text-gray-700">Link</label>
                    </td>
                    <td class="py-2">
                        <input
                            v-model="form.link"
                            type="url"
                            id="link"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.link" class="text-red-500 text-sm">{{ form.errors.link }}</span>
                    </td>
                </tr>
<!--                <tr>-->
<!--                    <td class="py-2 pr-4">-->
<!--                        <label for="referral_activated" class="block text-sm font-medium text-gray-700">Referral Activeren</label>-->
<!--                    </td>-->
<!--                    <td class="py-2">-->
<!--                        <select-->
<!--                            v-model="form.referral_activated"-->
<!--                            id="referral_activated"-->
<!--                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"-->
<!--                        >-->
<!--                            <option value="1">Actief</option>-->
<!--                            <option value="0">Inactief</option>-->
<!--                        </select>-->
<!--                        <span v-if="form.errors.referral_activated" class="text-red-500 text-sm">{{ form.errors.referral_activated }}</span>-->
<!--                    </td>-->
<!--                </tr>-->
                </tbody>
            </table>

            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-l"
                >
                    Referral Bijwerken
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import {Link, useForm} from "@inertiajs/vue3";

// Props
const props = defineProps({
    referral: Object,
});

const form = useForm({
    titel: props.referral.titel,
    omschrijving: props.referral.omschrijving,
    link: props.referral.link,
});

const update = () => form.put(route('referral.update', {referral: props.referral.id}));
</script>
