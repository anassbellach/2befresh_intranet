<template>
    <div class="p-8 max-w-6xl mx-auto">

        <success-messages></success-messages>

        <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-gray-900">
                Referrals
            </h1>
            <!-- Button -->
            <Link
                :href="route('referral.create')"
                class="bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-6 py-3 sm:px-8 sm:py-4 rounded-xl shadow-lg text-sm sm:text-base lg:text-lg hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all w-full sm:w-auto text-center"
            >
                Nieuwe Referral Aanmaken
            </Link>
        </div>

        <!-- Conditional Wrapper -->
        <div>
            <!-- Referrals List -->
            <div v-if="referrals.data.length" class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <div
                    v-for="referral in referrals.data"
                    :key="referral.id"
                    class="p-8 rounded-2xl shadow-lg transform transition-all duration-300"
                    :class="referral.deleted_at ? 'bg-gray-100 text-gray-500 hover:shadow-md' : 'bg-white hover:shadow-2xl hover:scale-105'"
                >
                    <!-- Gearchiveerd Badge -->
                    <span
                        v-if="referral.deleted_at"
                        class="inline-block px-3 py-1 text-xs font-semibold text-orange-700 bg-orange-200 rounded-full mb-4"
                    >
                    Gearchiveerd
                </span>

                    <h2
                        :class="referral.deleted_at ? 'text-gray-400 line-through' : 'text-gray-800 hover:text-pink-500'"
                        class="text-2xl font-bold mb-4"
                    >
                        {{ referral.titel }}
                    </h2>

                    <p :class="referral.deleted_at ? 'text-gray-400' : 'text-gray-500'" class="text-sm mb-6">
                        {{ referral.omschrijving }}
                    </p>

                    <!-- Responsive Input and Button -->
                    <div class="flex flex-col sm:flex-row items-center mb-6 gap-2">
                        <input
                            :value="referral.link"
                            readonly
                            class="bg-gray-100 text-gray-600 px-4 py-2 border border-gray-300 rounded-md focus:outline-none w-full sm:w-3/4"
                        />
                        <button
                            @click="copyToClipboard(referral.link)"
                            :class="referral.deleted_at
                                ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                : 'bg-gradient-to-r from-pink-500 to-yellow-500 text-white hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600'"
                            class="px-3 sm:px-4 py-2 text-sm sm:text-base rounded-md transition-all w-full sm:w-auto"
                            :disabled="referral.deleted_at"
                        >
                            Kopiëren
                        </button>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <Link
                            :href="route('referral.edit', { referral: referral.id })"
                            class="text-blue-600 hover:text-blue-700 transition-all"
                            v-if="!referral.deleted_at"
                        >
                            Bewerken
                        </Link>
                        <div class="flex space-x-3">
                            <button
                                @click="handleDeleteAction(referral)"
                                v-if="!referral.deleted_at"
                                class="text-red-600 hover:text-red-700 transition-all"
                            >
                                Verwijderen
                            </button>
                            <button
                                @click="handleRestore(referral)"
                                v-else
                                class="text-orange-600 hover:text-orange-700 font-semibold transition-all"
                            >
                                Herstellen
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fallback if Table is Empty -->
            <div v-else class="flex flex-col items-center justify-center bg-[#FCFCFC] rounded-xl shadow-lg p-12 text-center border border-gray-200">
                <i class="fas fa-folder-open text-gray-400 text-6xl mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-600">Geen referrals gevonden</h2>
                <p class="text-gray-500 mt-2">
                    Er zijn op dit moment geen referrals beschikbaar. Voeg een nieuwe toe om aan de slag te gaan!
                </p>
            </div>
        </div>

        <DeleteConfirmationModal
            v-if="showDeleteModal"
            message="Weet je zeker dat je deze referral wilt verwijderen?"
            @confirm="handleDelete"
            @close="handleClose"
        />

        <div v-if="referrals.data.length" class="flex justify-center mt-8">
            <Pagination :data="referrals" />
        </div>
    </div>
</template>


<script setup>
import {ref} from "vue";
import {Link, usePage, router} from "@inertiajs/vue3";
import Pagination from "@/Components/UI/Pagination.vue";
import SuccessMessages from "@/Components/SuccessMessages.vue";
import DeleteConfirmationModal from "@/Components/DeleteConfirmationModal.vue";

const {props} = usePage();
const referrals = props.referrals;
const filters = props.filters;

const searchQuery = ref(filters.search || "");
const showDeleteModal = ref(false);
const referralToDelete = ref(null);

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        flash.success = "Link gekopieerd naar klembord!";
        setTimeout(() => {
            flash.success = "";
        }, 3000);
    });
}

const updateFilters = () => {
    router.get(route("referral.index"), {...filters, search: searchQuery.value}, {preserveScroll: true});
};
const openDeleteModal = (referral) => {
    referralToDelete.value = referral;
    showDeleteModal.value = true;
};

const handleDelete = async () => {
    if (referralToDelete.value) {
        try {
            await router.delete(route("referral.destroy", {referral: referralToDelete.value.id}));
            referrals.data = referrals.data.map((g) =>
                g.id === referralToDelete.value.id ? {...g, deleted_at: true} : g
            );
            showDeleteModal.value = false;
        } catch (error) {
            console.error("Fout bij het verwijderen van de referral:", error);
        }
    }
};

const handleRestore = async (referral) => {
    try {
        await router.put(route("referral.restore", {referral: referral.id}));
        referrals.data = referrals.data.map((g) =>
            g.id === referral.id ? {...g, deleted_at: null} : g
        );
    } catch (error) {
        console.error("Fout bij het herstellen van de referral:", error);
    }
};

const handleDeleteAction = (referral) => {
    openDeleteModal(referral);
};

const handleClose = () => {
    showDeleteModal.value = false;
    referralToDelete.value = null;
};
</script>
