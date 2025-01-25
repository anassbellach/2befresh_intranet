<template>
    <div class="px-4">
        <div class="p-6 max-w-6xl mx-auto bg-white shadow-lg rounded-2xl mb-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center justify-between w-full">
                    <h1 class="text-xl sm:text-3xl font-semibold text-gray-800">Referral aanmaken</h1>

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

            <form @submit.prevent="create">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Titel -->
                    <div>
                        <label for="titel" class="block text-sm font-medium text-gray-700">
                            Titel <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.titel"
                            type="text"
                            id="titel"
                            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.titel" class="text-red-500 text-sm">{{ form.errors.titel }}</span>
                    </div>

                    <!-- Omschrijving -->
                    <div>
                        <label for="omschrijving" class="block text-sm font-medium text-gray-700">
                            Omschrijving <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            v-model="form.omschrijving"
                            id="omschrijving"
                            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        ></textarea>
                        <span v-if="form.errors.omschrijving" class="text-red-500 text-sm">{{ form.errors.omschrijving }}</span>
                    </div>

                    <!-- Link -->
                    <div>
                        <label for="link" class="block text-sm font-medium text-gray-700">
                            Link <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.link"
                            id="link"
                            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <span v-if="form.errors.link" class="text-red-500 text-sm">{{ form.errors.link }}</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-6">
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all"
                    >
                        Referral Aanmaken
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>


<script setup>
import { Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    titel: "",
    omschrijving: "",
    link: "",
    referral_activated: "1",
});

const create = () => form.post(route('referral.store'));
</script>
