<template>
    <div class="p-8">
        <!-- Flash Bericht -->
        <success-messages></success-messages>

        <div class="flex flex-col max-w-6xl mx-auto">
            <!-- Header Sectie -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-semibold text-gray-900">Leveranciers</h1>
                <Link
                    :href="route('leverancier.create')"
                    class="bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-8 py-4 rounded-xl shadow-lg hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all"
                >
                    Nieuwe Leverancier Aanmaken
                </Link>
            </div>

            <!-- Zoekbalk -->
            <div class="mb-6">
                <input
                    v-model="searchQuery"
                    @input="updateFilters"
                    type="text"
                    placeholder="Zoek leveranciers..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
            </div>

            <!-- Leveranciers Tabel -->
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full table-auto border-collapse">
                    <!-- Tabel Hoofd -->
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

                    <!-- Tabel Body -->
                    <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                    <tr
                        v-for="leverancier in leveranciers.data"
                        :key="leverancier.leverancier_id"
                        class="hover:bg-gray-50 transition-all"
                    >
                        <td class="px-6 py-4">{{ leverancier.leverancier_id }}</td>
                        <td class="px-6 py-4">{{ leverancier.leverancier_bedrijfsnaam }}</td>
                        <td class="px-6 py-4">{{ leverancier.leverancier_plaats }}</td>
                        <td class="px-6 py-4">{{ leverancier.leverancier_email }}</td>
                        <td class="px-6 py-4">
                            <span
                                :class="[leverancier.deleted_at === null
                                    ? 'text-green-800 bg-green-100'
                                    : 'text-red-800 bg-red-100']"
                                class="px-3 py-1 rounded-full text-xs font-medium"
                            >
                                {{ leverancier.deleted_at === null ? 'Actief' : 'Inactief' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
                            <Link
                                :href="route('leverancier.show', { leverancier: leverancier.leverancier_id })"
                                class="bg-green-100 text-green-600 px-2 py-1 rounded-lg hover:bg-green-200"
                                aria-label="Bekijken"
                            >
                                <i class="fa-solid fa-eye"></i>
                            </Link>
                            <Link
                                :href="route('leverancier.edit', { leverancier: leverancier.leverancier_id })"
                                class="bg-blue-100 text-blue-600 px-2 py-1 rounded-lg hover:bg-blue-200"
                                aria-label="Bewerken"
                            >
                                <i class="fa-solid fa-pencil-alt"></i>
                            </Link>
                            <button
                                @click="handleDeleteAction(leverancier)"
                                v-if="!leverancier.deleted_at"
                                class="bg-red-100 text-red-600 px-2 py-1 rounded-lg hover:bg-red-200"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <Link
                                @click="handleRestore(leverancier)"
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
        </div>

        <!-- Bevestigingsmodal voor Verwijderen -->
        <DeleteConfirmationModal
            v-if="showDeleteModal"
            message="Weet u zeker dat u deze leverancier wilt verwijderen?"
            @confirm="handleDelete"
            @close="handleClose"
        />

        <!-- Paginering -->
        <div v-if="leveranciers.data.length" class="flex justify-center mt-6">
            <Pagination :data="leveranciers" />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { usePage, router, Link } from "@inertiajs/vue3";
import Pagination from "@/Components/UI/Pagination.vue";
import SuccessMessages from "@/Components/SuccessMessages.vue";
import DeleteConfirmationModal from "@/Components/DeleteConfirmationModal.vue";

// Definieer props
const { props } = usePage();
const leveranciers = props.leveranciers;
const filters = props.filters;

// Definieer reactieve variabelen
const searchQuery = ref(filters.search || "");
const showDeleteModal = ref(false);
const leverancierToDelete = ref(null);

const headers = [
    { key: "leverancier_id", label: "ID" },
    { key: "leverancier_bedrijfsnaam", label: "Naam" },
    { key: "leverancier_plaats", label: "Plaats" },
    { key: "leverancier_email", label: "E-mailadres" },
    { key: "leverancier_actief", label: "Actief" },
];

// Filters en sortering bijwerken
const updateFilters = () => {
    router.get(route("leverancier.index"), { ...filters, search: searchQuery.value }, { preserveScroll: true });
};

const updateSorting = (key) => {
    const sortOrder = filters.sortKey === key && filters.sortOrder === "asc" ? "desc" : "asc";
    router.get(route("leverancier.index"), { ...filters, sortKey: key, sortOrder }, { preserveScroll: true });
};

const openDeleteModal = (leverancier) => {
    leverancierToDelete.value = leverancier;
    showDeleteModal.value = true;
};

const handleDelete = async () => {
    if (leverancierToDelete.value) {
        try {
            await router.delete(route("leverancier.destroy", { leverancier: leverancierToDelete.value.leverancier_id }));
            leveranciers.data = leveranciers.data.map((g) =>
                g.leverancier_id === leverancierToDelete.value.leverancier_id ? { ...g, deleted_at: true } : g
            );
            showDeleteModal.value = false;
        } catch (error) {
            console.error("Fout bij het verwijderen van leverancier:", error);
        }
    }
};

const handleRestore = async (leverancier) => {
    try {
        await router.put(route("leverancier.restore", { leverancier: leverancier.leverancier_id }));
        leveranciers.data = leveranciers.data.map((g) =>
            g.leveranciers === leverancier.leveranciers ? { ...g, deleted_at: null } : g
        );
    } catch (error) {
        console.error("Fout bij het herstellen van leverancier:", error);
    }
};

const handleDeleteAction = (leverancier) => {
    openDeleteModal(leverancier);
};

const handleClose = () => {
    showDeleteModal.value = false;
    leverancierToDelete.value = null;
};
</script>
