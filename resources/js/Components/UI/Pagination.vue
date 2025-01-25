<template>
    <div
        class="flex justify-start items-center space-x-2 my-6 pb-2 overflow-x-auto scrollbar-hide px-4 snap-x snap-mandatory"
    >
    <!-- Previous Button -->
    <Link
        v-if="data?.prev_page_url"
        :href="data.prev_page_url"
        class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 bg-white text-gray-600 shadow-md hover:shadow-lg hover:bg-gradient-to-r hover:from-pink-500 hover:to-yellow-500 hover:text-white flex-shrink-0 snap-start"
        aria-label="Previous"
    >
        <i class="fas fa-chevron-left"></i>
    </Link>

    <!-- First Page Button -->
    <Link
        :href="`?page=1`"
        class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 font-medium flex-shrink-0 snap-start shadow-md"
        :class="{
        'bg-gradient-to-r from-pink-500 to-yellow-500 text-white shadow-md': currentPage === 1,
        'bg-white text-gray-600 hover:shadow-lg hover:bg-gradient-to-r hover:from-pink-500 hover:to-yellow-500 hover:text-white': currentPage !== 1
      }"
    >
        1
    </Link>

    <!-- Dots before visible pages -->
    <span
        v-if="showFirstPageDots"
        class="flex items-center justify-center w-10 h-10 text-gray-600 flex-shrink-0 snap-start"
    >
      ...
    </span>

    <!-- Visible Page Buttons -->
    <Link
        v-for="page in visiblePages"
        :key="page"
        :href="`?page=${page}`"
        class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 font-medium flex-shrink-0 snap-start shadow-md"
        :class="{
        'bg-gradient-to-r from-pink-500 to-yellow-500 text-white shadow-md': currentPage === page,
        'bg-white text-gray-600 hover:shadow-lg hover:bg-gradient-to-r hover:from-pink-500 hover:to-yellow-500 hover:text-white': currentPage !== page
      }"
    >
        {{ page }}
    </Link>

    <!-- Dots after visible pages -->
    <span
        v-if="showLastPageDots"
        class="flex items-center justify-center w-10 h-10 text-gray-600 flex-shrink-0 snap-start"
    >
      ...
    </span>

    <!-- Last Page Button -->
    <Link
        v-if="currentPage !== totalPages && totalPages > 6"
        :href="`?page=${totalPages}`"
        class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 font-medium bg-white text-gray-600 shadow-md hover:shadow-lg hover:bg-gradient-to-r hover:from-pink-500 hover:to-yellow-500 hover:text-white flex-shrink-0 snap-start"
    >
        {{ totalPages }}
    </Link>

    <!-- Next Button -->
    <Link
        v-if="data?.next_page_url"
        :href="data.next_page_url"
        class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 bg-white text-gray-600 shadow-md hover:shadow-lg hover:bg-gradient-to-r hover:from-pink-500 hover:to-yellow-500 hover:text-white flex-shrink-0 snap-start"
        aria-label="Next"
    >
        <i class="fas fa-chevron-right"></i>
    </Link>
    </div>
</template>



<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

// Define props for paginated data
const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

// Ensure the data prop is properly structured, with defaults if undefined
const data = computed(() => props.data || { current_page: 1, last_page: 1, prev_page_url: null, next_page_url: null });

// Get the current page and total pages
const currentPage = computed(() => data.value.current_page);
const totalPages = computed(() => data.value.last_page);

// Calculate visible pages (limit to 5)
const visiblePages = computed(() => {
    const pagesToShow = 5;
    let startPage = Math.max(2, currentPage.value - Math.floor(pagesToShow / 2));
    let endPage = Math.min(totalPages.value, startPage + pagesToShow - 1);

    if (endPage - startPage < pagesToShow - 1) {
        startPage = Math.max(2, endPage - pagesToShow + 1);
    }

    return Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);
});

// Determine whether to show dots before the visible pages
const showFirstPageDots = computed(() => {
    return visiblePages.value[0] > 2;
});

// Determine whether to show dots after the visible pages
const showLastPageDots = computed(() => {
    return visiblePages.value[visiblePages.value.length - 1] < totalPages.value - 1;
});
</script>

<style scoped>
/* Custom styles */
span {
    line-height: 1;
}
</style>
