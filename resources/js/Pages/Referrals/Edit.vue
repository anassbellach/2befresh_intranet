<template>
    <div class="px-4">
        <div class="p-4 sm:p-8 max-w-6xl mx-auto bg-white shadow-lg rounded-2xl mb-8">

            <div class="flex justify-between items-center mb-6">
                <!-- Title and Back Button -->
                <div class="flex items-center justify-between w-full">
                    <!-- Title -->
                    <h1 class="text-xl sm:text-3xl font-semibold text-gray-800">Referral Bewerken</h1>

                    <!-- Back Button -->
                    <Link
                        :href="route('referral.index')"
                        class="inline-flex items-center justify-center w-10 h-10 bg-gray-200 text-gray-700 rounded-full shadow hover:bg-gray-300 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </Link>
                </div>
            </div>

            <form @submit.prevent="update">
                <!-- Using grid layout -->
                <div class="grid grid-cols-1 gap-6">
                    <!-- Titel -->
                    <div class="flex flex-col">
                        <label for="titel" class="text-sm font-medium text-gray-700">
                            Titel <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.titel"
                            type="text"
                            id="titel"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.titel" class="text-red-500 text-sm">{{ form.errors.titel }}</span>
                    </div>

                    <!-- Omschrijving -->
                    <div class="flex flex-col">
                        <label for="omschrijving" class="text-sm font-medium text-gray-700">
                            Omschrijving <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            v-model="form.omschrijving"
                            id="omschrijving"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        ></textarea>
                        <span v-if="form.errors.omschrijving" class="text-red-500 text-sm">{{ form.errors.omschrijving }}</span>
                    </div>

                    <!-- Link -->
                    <div class="flex flex-col">
                        <label for="link" class="text-sm font-medium text-gray-700">
                            Link <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.link"
                            type="url"
                            id="link"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        <span v-if="form.errors.link" class="text-red-500 text-sm">{{ form.errors.link }}</span>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all"
                    >
                        Referral Bijwerken
                    </button>
                </div>
            </form>
        </div>
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
