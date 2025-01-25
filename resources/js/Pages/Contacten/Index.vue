<template>
    <div class="p-8">
        <!-- Flash Bericht -->
        <success-messages></success-messages>

        <div class="flex flex-col max-w-6xl mx-auto">
            <!-- Header Sectie -->
            <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
                <!-- Title -->
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-gray-900">
                    Contacten
                </h1>
                <!-- Button -->
                <Link
                    :href="route('contact.create')"
                    class="bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-6 py-3 sm:px-8 sm:py-4 rounded-xl shadow-lg text-sm sm:text-base lg:text-lg hover:bg-gradient-to-r hover:from-pink-600 hover:to-yellow-600 transition-all w-full sm:w-auto text-center"
                >
                    Nieuw Contact Aanmaken
                </Link>
            </div>

            <!-- Zoekbalk -->
            <div v-if="contacten.data.length" class="mb-6">
                <input
                    v-model="searchQuery"
                    @input="updateFilters"
                    type="text"
                    placeholder="Zoek contactpersonen..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
            </div>

            <!-- Contacten Tabel -->
            <div v-if="contacten.data.length" class="overflow-x-auto bg-white shadow-md rounded-lg">
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
                        v-for="contact in contacten.data"
                        :key="contact.contact_id"
                        class="hover:bg-gray-50 transition-all"
                    >
                        <!-- Data Columns -->
                        <td class="px-6 py-4">{{ contact.contact_id }}</td>
                        <td class="px-6 py-4">{{ contact.contact_naam }}</td>
                        <td class="px-6 py-4">{{ contact.contact_telefoon }}</td>
                        <td class="px-6 py-4">{{ contact.contact_mail }}</td>
                        <td class="px-6 py-4">
                            <span
                                :class="[contact.contact_actief === 1 ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100']"
                                class="px-3 py-1 rounded-full text-xs font-medium inline-block"
                            >
                                {{ contact.deleted_at === null ? 'Actief' : 'Inactief' }}
                            </span>
                        </td>
                        <!-- Actions Column -->
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-start gap-2">
                                <Link
                                    :href="route('contact.show', { contact: contact.contact_id })"
                                    class="bg-green-100 text-green-600 px-3 py-2 rounded-lg hover:bg-green-200 flex items-center justify-center"
                                >
                                    <i class="fa-solid fa-eye"></i>
                                </Link>
                                <Link
                                    :href="route('contact.edit', { contact: contact.contact_id })"
                                    class="bg-blue-100 text-blue-600 px-3 py-2 rounded-lg hover:bg-blue-200 flex items-center justify-center"
                                >
                                    <i class="fa-solid fa-pencil-alt"></i>
                                </Link>
                                <button
                                    @click="openDeleteModal(contact)"
                                    v-if="!contact.deleted_at"
                                    class="bg-red-100 text-red-600 px-3 py-2 rounded-lg hover:bg-red-200 flex items-center justify-center"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <Link
                                    @click="handleRestore(contact)"
                                    v-else
                                    class="bg-orange-100 text-orange-600 px-3 py-2 rounded-lg hover:bg-orange-200 flex items-center justify-center"
                                >
                                    <i class="fa-solid fa-trash-arrow-up"></i>
                                </Link>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Fallback if table is empty -->
            <div
                v-else
                class="flex flex-col items-center justify-center bg-[#FCFCFC] rounded-xl shadow-lg p-12 text-center border border-gray-200"
            >
                <i class="fas fa-folder-open text-gray-400 text-6xl mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-600">Geen contacten gevonden</h2>
                <p class="text-gray-500 mt-2">
                    Er zijn op dit moment geen contacten beschikbaar. Voeg een nieuwe toe om aan de slag te gaan!
                </p>
            </div>
        </div>

        <!-- Paginering -->
        <div v-if="contacten.data.length" class="flex justify-center mt-6">
            <Pagination :data="contacten" />
        </div>

        <!-- Verwijder Bevestigingsmodal -->
        <DeleteConfirmationModal
            v-if="showDeleteModal"
            message="Weet u zeker dat u dit contact wilt verwijderen?"
            @confirm="handleDelete"
            @close="handleClose"
        />
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
const contacten = props.contacten;
const filters = props.filters;

// State
const searchQuery = ref(filters.search || "");
const headers = [
    { key: "contact_id", label: "ID" },
    { key: "contact_naam", label: "Naam" },
    { key: "contact_telefoon", label: "Telefoonnummer" },
    { key: "contact_mail", label: "E-mailadres" },
    { key: "contact_actief", label: "Status" },
];

const showDeleteModal = ref(false);
const contactToDelete = ref(null);

// Methoden
const updateFilters = () => {
    router.get(route("contact.index"), { ...filters, search: searchQuery.value }, { preserveScroll: true });
};

const updateSorting = (key) => {
    const sortOrder = filters.sortKey === key && filters.sortOrder === "asc" ? "desc" : "asc";
    router.get(route("contact.index"), { ...filters, sortKey: key, sortOrder }, { preserveScroll: true });
};

// Open de Verwijderbevestigingsmodal
const openDeleteModal = (contact) => {
    contactToDelete.value = contact;
    showDeleteModal.value = true;
};

// Verwerk het Verwijderen van een Contact
const handleDelete = async () => {
    if (contactToDelete.value) {
        try {
            await router.delete(route("contact.destroy", { contact: contactToDelete.value.contact_id }));
            contacten.data = contacten.data.map((g) =>
                g.contact_id === contactToDelete.value.contact_id ? { ...g, deleted_at: true } : g
            );
            showDeleteModal.value = false;
        } catch (error) {
            console.error("Fout bij verwijderen van contact:", error);
        }
    }
};

const handleRestore = async (contact) => {
    try {
        await router.put(route("contact.restore", { contact: contact.contact_id }));
        contacten.data = contacten.data.map((g) =>
            g.contact_id === contact.contact_id ? { ...g, deleted_at: null } : g
        );
    } catch (error) {
        console.error("Fout bij herstellen van contact:", error);
    }
};

// Sluit de Modal
const handleClose = () => {
    showDeleteModal.value = false;
    contactToDelete.value = null;
};
</script>
