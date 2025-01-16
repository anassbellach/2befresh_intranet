<template>
    <div class="p-6 space-y-8 min-h-screen max-w-6xl mx-auto">
        <!-- Hoofdstatistieken Sectie -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Statistiekenkaart: Klanten -->
            <a class="relative group rounded-3xl"
               :href="route('klant.index')">
                <div class="p-6 rounded-3xl bg-white flex flex-col text-black shadow-md transform transition-transform hover:scale-105 hover:ring-2 hover:ring-offset-2 hover:ring-[#F1487A] relative overflow-hidden hover:shadow-[0_0_25px_#F1487A] hover:cursor-pointer">
                    <div class="absolute -bottom-5 -right-5 w-48 h-48 bg-opacity-20 rounded-full flex items-center justify-center transform rotate-[-45deg] scale-125 z-0">
                        <i class="fas fa-users text-[#F1487A] text-[10rem]"></i>
                    </div>
                    <div class="relative z-10 text-[#1A1952]">
                        <div class="flex justify-between items-center">
                            <h2 class="font-semibold text-2xl">Klanten</h2>
                        </div>
                        <p class="text-4xl mt-2 font-bold">{{ klanten_count }}</p>
                        <p class="text-sm mt-2" :class="klanten_NewThisYear > 0 ? 'text-green-500' : 'text-gray-500'">
                            <span v-if="klanten_NewThisYear > 0">
                                ▲ {{ klanten_NewThisYear }} nieuwe klanten dit jaar
                            </span>
                            <span v-else>
                                Geen verandering dit jaar
                            </span>
                        </p>
                    </div>
                </div>
            </a>

            <!-- Statistiekenkaart: Leveranciers -->
            <a class="relative group rounded-3xl"
               :href="route('leverancier.index')">
                <div class="p-6 rounded-3xl bg-white flex flex-col text-black shadow-md transform transition-transform hover:scale-105 hover:ring-2 hover:ring-offset-2 hover:ring-[#FF6F48] relative overflow-hidden hover:shadow-[0_0_25px_#FF6F48] hover:cursor-pointer">
                    <div class="absolute -bottom-5 -right-5 w-48 h-48 bg-opacity-20 rounded-full flex items-center justify-center transform rotate-[-45deg] scale-125 z-0">
                        <i class="fas fa-truck text-[#FF6F48] text-[10rem]"></i>
                    </div>
                    <div class="relative z-10 text-[#1A1952]">
                        <div class="flex justify-between items-center">
                            <h2 class="font-semibold text-2xl">Leveranciers</h2>
                        </div>
                        <p class="text-4xl mt-2 font-bold">{{ leveranciers_count }}</p>
                        <p class="text-sm mt-2" :class="leveranciers_NewThisYear > 0 ? 'text-green-500' : 'text-gray-500'">
                            <span v-if="leveranciers_NewThisYear > 0">
                                ▲ {{ leveranciers_NewThisYear }} nieuwe leveranciers dit jaar
                            </span>
                            <span v-else>
                                Geen verandering dit jaar
                            </span>
                        </p>
                    </div>
                </div>
            </a>

            <!-- Statistiekenkaart: Contacten -->
            <a class="relative group rounded-3xl"
               :href="route('contact.index')">
                <div class="p-6 rounded-3xl bg-white flex flex-col text-black shadow-md transform transition-transform hover:scale-105 hover:ring-2 hover:ring-offset-2 hover:ring-[#FFA532] relative overflow-hidden hover:shadow-[0_0_25px_#FFA532] hover:cursor-pointer">
                    <div class="absolute -bottom-5 -right-5 w-48 h-48 bg-opacity-20 rounded-full flex items-center justify-center transform rotate-[-45deg] scale-125 z-0">
                        <i class="fas fa-address-book text-[#FFA532] text-[10rem]"></i>
                    </div>
                    <div class="relative z-10 text-[#1A1952]">
                        <div class="flex justify-between items-center">
                            <h2 class="font-semibold text-2xl">Contacten</h2>
                        </div>
                        <p class="text-4xl mt-2 font-bold">{{ contacten_count }}</p>
                        <p class="text-sm mt-2" :class="contacten_NewThisYear > 0 ? 'text-green-500' : 'text-gray-500'">
                            <span v-if="contacten_NewThisYear > 0">
                                ▲ {{ contacten_NewThisYear }} nieuwe contacten dit jaar
                            </span>
                            <span v-else>
                                Geen verandering dit jaar
                            </span>
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Grafieken Sectie -->
        <div class="p-6 rounded-3xl bg-white shadow-md">
            <h3 class="text-lg font-semibold mb-4">Nieuwe klanten per jaar</h3>
            <canvas id="klantenGrowthChart" class="max-h-96 w-full"></canvas>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { Chart } from "chart.js/auto";

// Props definitie
const props = defineProps({
    klanten_count: Number,
    klanten_NewThisYear: Number,
    leveranciers_count: Number,
    leveranciers_NewThisYear: Number,
    contacten_count: Number,
    contacten_NewThisYear: Number,
    klanten_growth_by_year: Object,
});

// Instellen van de grafiek
onMounted(() => {
    const klantenGrowthCtx = document
        .getElementById("klantenGrowthChart")
        .getContext("2d");

    const gradient = klantenGrowthCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, '#F1487A');
    gradient.addColorStop(1, '#FFA532');

    new Chart(klantenGrowthCtx, {
        type: 'line',
        data: {
            labels: Object.keys(props.klanten_growth_by_year).map(year => year),
            datasets: [{
                label: 'Nieuwe Klanten',
                data: Object.values(props.klanten_growth_by_year),
                borderColor: '#1A1952',
                backgroundColor: gradient,
                tension: 0.4,
                fill: true,
                borderWidth: 2,
                pointRadius: 5,
                pointBackgroundColor: '#1A1952',
                pointBorderWidth: 2,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#1A1952',
                    },
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Jaren',
                        color: '#6B7280',
                    },
                    ticks: {
                        color: '#6B7280',
                    },
                    grid: {
                        color: '#E5E7EB',
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: 'Nieuwe Klanten',
                        color: '#6B7280',
                    },
                    ticks: {
                        color: '#6B7280',
                    },
                    grid: {
                        color: '#E5E7EB',
                    },
                    beginAtZero: true,
                },
            },
        },
    });
});
</script>
