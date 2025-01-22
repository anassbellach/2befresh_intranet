<template>
    <div class="p-8">
        <!-- Flash Bericht -->
        <success-messages></success-messages>

        <div class="flex flex-col max-w-6xl mx-auto">
            <!-- Header Sectie -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-semibold text-gray-900">Gebruikers</h1>
                <Link
                    :href="route('gebruiker.create')"
                    class="bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-8 py-4 rounded-xl shadow-lg hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all"
                >
                    Nieuwe Gebruiker Aanmaken
                </Link>
            </div>

            <!-- Zoekbalk -->
            <div class="mb-6">
                <input
                    v-model="searchQuery"
                    @input="updateFilters"
                    type="text"
                    placeholder="Zoek gebruikers..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
            </div>

            <!-- Tabel -->
            <div v-if="gebruikers.data.length" class="overflow-x-auto bg-white shadow-md rounded-lg">
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
                        <th class="px-6 py-4">Actie</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                    <tr
                        v-for="gebruiker in gebruikers.data"
                        :key="gebruiker.user_id"
                        class="hover:bg-gray-50 transition-all"
                    >
                        <td class="px-6 py-4">{{ gebruiker.user_id }}</td>
                        <td class="px-6 py-4">
                            {{ gebruiker.user_firstname }} {{ gebruiker.user_lastname }}
                        </td>
                        <td class="px-6 py-4">{{ gebruiker.email }}</td>
                        <td class="px-6 py-4">{{ gebruiker.user_rol }}</td>
                        <td class="px-6 py-4">
                                <span
                                    :class="[gebruiker.deleted_at === null ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100']"
                                    class="px-3 py-1 rounded-full text-xs font-medium"
                                >
                                    {{ gebruiker.deleted_at === null ? 'Actief' : 'Inactief' }}
                                </span>
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
                            <Link
                                :href="route('gebruiker.show', { gebruiker: gebruiker.user_id })"
                                class="bg-green-100 text-green-600 px-2 py-1 rounded-lg hover:bg-green-200"
                                aria-label="Bekijk"
                            >
                                <i class="fa-solid fa-eye"></i>
                            </Link>
                            <Link
                                :href="route('gebruiker.edit', { gebruiker: gebruiker.user_id })"
                                class="bg-blue-100 text-blue-600 px-2 py-1 rounded-lg hover:bg-blue-200"
                                aria-label="Bewerken"
                            >
                                <i class="fa-solid fa-pencil-alt"></i>
                            </Link>
                            <button
                                @click="handleDeleteAction(gebruiker)"
                                v-if="!gebruiker.deleted_at"
                                class="bg-red-100 text-red-600 px-2 py-1 rounded-lg hover:bg-red-200"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <Link
                                @click="handleRestore(gebruiker)"
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
                <h2 class="text-2xl font-semibold text-gray-600">Geen gebruikers gevonden</h2>
                <p class="text-gray-500 mt-2">
                    Er zijn op dit moment geen gebruikers beschikbaar. Voeg een nieuwe toe om aan de slag te gaan!
                </p>
            </div>
        </div>

        <!-- Verwijderbevestigingsmodal -->
        <DeleteConfirmationModal
            v-if="showDeleteModal"
            message="Weet je zeker dat je deze gebruiker wilt verwijderen?"
            @confirm="handleDelete"
            @close="handleClose"
        />

        <!-- Paginatiecomponent -->
        <div v-if="gebruikers.data.length" class="flex justify-center mt-6">
            <Pagination :data="gebruikers" />
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
const gebruikers = props.gebruikers;
const filters = props.filters;

// State
const searchQuery = ref(filters.search || "");
const headers = [
    { key: "user_id", label: "ID" },
    { key: "user_firstname", label: "Naam" },
    { key: "email", label: "E-mailadres" },
    { key: "user_rol", label: "Rol" },
    { key: "user_activated", label: "Status" },
];
const showDeleteModal = ref(false);
const gebruikerToDelete = ref(null);

// Methods
const updateFilters = () => {
    router.get(route("gebruiker.index"), { ...filters, search: searchQuery.value }, { preserveScroll: true });
};

const updateSorting = (key) => {
    const sortOrder = filters.sortKey === key && filters.sortOrder === "asc" ? "desc" : "asc";
    router.get(route("gebruiker.index"), {...filters, sortKey: key, sortOrder}, {preserveScroll: true});
};

const openDeleteModal = (gebruiker) => {
    gebruikerToDelete.value = gebruiker;
    showDeleteModal.value = true;
};

const handleDelete = async () => {
    if (gebruikerToDelete.value) {
        try {
            await router.delete(route("gebruiker.destroy", {gebruiker: gebruikerToDelete.value.user_id}));
            gebruikers.data = gebruikers.data.map((g) =>
                g.user_id === gebruikerToDelete.value.user_id ? {...g, deleted_at: true} : g
            );
            showDeleteModal.value = false;
        } catch (error) {
            console.error("Fout bij het verwijderen van gebruiker:", error);
        }
    }
};

const handleRestore = async (gebruiker) => {
    try {
        await router.put(route("gebruiker.restore", {gebruiker: gebruiker.user_id}));
        gebruikers.data = gebruikers.data.map((g) =>
            g.user_id === gebruiker.user_id ? {...g, deleted_at: null} : g
        );
    } catch (error) {
        console.error("Fout bij het herstellen van gebruiker:", error);
    }
};

const handleDeleteAction = (gebruiker) => {
    openDeleteModal(gebruiker);
};

const handleClose = () => {
    showDeleteModal.value = false;
    gebruikerToDelete.value = null;
};
</script>
