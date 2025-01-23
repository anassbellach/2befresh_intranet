<template>
    <div class="p-8">
        <!-- Succesbericht -->
        <success-messages></success-messages>

        <div class="flex flex-col max-w-6xl mx-auto">
            <!-- Header Sectie -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-semibold text-gray-900">Klanten</h1>
                <Link
                    :href="route('klant.create')"
                    class="bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-8 py-4 rounded-xl shadow-lg hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all"
                >
                    Nieuwe Klant Aanmaken
                </Link>
            </div>


            <!-- Zoekbalk -->
            <div v-if="klanten.data.length" class="mb-6">
                <input
                    v-model="searchQuery"
                    @input="updateFilters"
                    type="text"
                    placeholder="Zoek klanten..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
            </div>

            <!-- Tabel -->
            <div v-if="klanten.data.length" class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full table-auto border-collapse">
                    <thead class="bg-[#1B1952] text-white sticky top-0 z-10">
                    <tr>
                        <th
                            v-for="header in headers"
                            :key="header.key"
                            @click="updateSorting(header.key)"
                            class="px-6 py-4 text-left text-sm font-semibold cursor-pointer hover:bg-[#2c2763]"
                        >
                            {{ header.label }}
                            <span v-if="filters.sortKey === header.key">
                                <i :class="filters.sortOrder === 'asc' ? 'fa-solid fa-arrow-up' : 'fa-solid fa-arrow-down'"></i>
                            </span>
                        </th>
                        <th class="px-6 py-4">Acties</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                    <tr
                        v-for="klant in klanten.data"
                        :key="klant.klant_id"
                        class="hover:bg-gray-50 transition-all"
                    >
                        <td class="px-6 py-4">{{ klant.klant_id }}</td>
                        <td class="px-6 py-4">{{ klant.klant_bedrijfsnaam }}</td>
                        <td class="px-6 py-4">{{ klant.klant_plaats }}</td>
                        <td class="px-6 py-4">{{ klant.klant_mail }}</td>
                        <td class="px-6 py-4">{{ klant.klant_sinds }}</td>
                        <td class="px-6 py-4">
                            <span
                                :class="[klant.deleted_at === null ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100']"
                                class="px-3 py-1 rounded-full text-xs font-medium"
                            >
                                {{ klant.deleted_at === null ? 'Actief' : 'Inactief' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
                            <Link :href="route('klant.show', { klant: klant.klant_id })" class="bg-green-100 text-green-600 px-2 py-1 rounded-lg hover:bg-green-200">
                                <i class="fa-solid fa-eye"></i>
                            </Link>
                            <Link :href="route('klant.edit', { klant: klant.klant_id })" class="bg-blue-100 text-blue-600 px-2 py-1 rounded-lg hover:bg-blue-200">
                                <i class="fa-solid fa-pencil-alt"></i>
                            </Link>
                            <button
                                @click="handleDeleteAction(klant)"
                                v-if="!klant.deleted_at"
                                class="bg-red-100 text-red-600 px-2 py-1 rounded-lg hover:bg-red-200"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <Link
                                @click="handleRestore(klant)"
                                v-else
                                class="bg-orange-100 text-orange-600 px-2 py-1 rounded-lg hover:bg-orange-200"
                            >
                                <i class="fa-solid fa-trash-arrow-up"></i>
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Fallback if table is empty -->
            <div v-else class="flex flex-col items-center justify-center bg-[#FCFCFC] rounded-xl shadow-lg p-12 text-center border border-gray-200">
                <i class="fas fa-folder-open text-gray-400 text-6xl mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-600">Geen klanten gevonden</h2>
                <p class="text-gray-500 mt-2">
                    Er zijn op dit moment geen klanten beschikbaar. Voeg een nieuwe toe om aan de slag te gaan!
                </p>
            </div>
        </div>

        <!-- Verwijder Bevestigingsvenster -->
        <DeleteConfirmationModal
            v-if="showDeleteModal"
            message="Weet je zeker dat je deze klant wilt verwijderen?"
            @confirm="handleDelete"
            @close="handleClose"
        />

        <!-- Paginatie -->
        <div v-if="klanten.data.length" class="flex justify-center mt-6">
            <Pagination :data="klanten" />
        </div>

    </div>
</template>

<script setup>
import { ref } from "vue";
import { usePage, router, Link } from "@inertiajs/vue3";
import Pagination from "@/Components/UI/Pagination.vue";
import SuccessMessages from "@/Components/SuccessMessages.vue";
import DeleteConfirmationModal from "@/Components/DeleteConfirmationModal.vue";

// Props
const { props } = usePage();
const klanten = props.klanten;
const filters = props.filters;

// State
const searchQuery = ref(filters.search || "");
const headers = [
    { key: "klant_id", label: "ID" },
    { key: "klant_bedrijfsnaam", label: "Naam" },
    { key: "klant_plaats", label: "Plaats" },
    { key: "klant_mail", label: "E-mailadres" },
    { key: "klant_sinds", label: "Klant Sinds" },
    { key: "klant_actief", label: "Status" },
];
const showDeleteModal = ref(false);
const klantToDelete = ref(null);

// Methods
const updateFilters = () => {
    router.get(route("klant.index"), { ...filters, search: searchQuery.value }, { preserveScroll: true });
};

const updateSorting = (key) => {
    const sortOrder = filters.sortKey === key && filters.sortOrder === "asc" ? "desc" : "asc";
    router.get(route("klant.index"), { ...filters, sortKey: key, sortOrder }, { preserveScroll: true });
};

const openDeleteModal = (klant) => {
    klantToDelete.value = klant;
    showDeleteModal.value = true;
};

const handleDelete = async () => {
    if (klantToDelete.value) {
        try {
            await router.delete(route("klant.destroy", { klant: klantToDelete.value.klant_id }));
            klanten.data = klanten.data.map((g) =>
                g.klant_id === klantToDelete.value.klant_id ? { ...g, deleted_at: true } : g
            );
            showDeleteModal.value = false;
        } catch (error) {
            console.error("Fout bij het verwijderen van klant:", error);
        }
    }
};

const handleRestore = async (klant) => {
    try {
        await router.put(route("klant.restore", { klant: klant.klant_id }));
        klanten.data = klanten.data.map((g) =>
            g.klanten === klant.klanten ? { ...g, deleted_at: null } : g
        );
    } catch (error) {
        console.error("Fout bij het herstellen van klant:", error);
    }
};

const handleDeleteAction = (klant) => {
    openDeleteModal(klant);
};

const handleClose = () => {
    showDeleteModal.value = false;
    klantToDelete.value = null;
};
</script>
