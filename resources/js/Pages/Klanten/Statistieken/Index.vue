<template>
    <div class="px-8 pt-4 flex justify-center min-h-full">
        <div class="rounded-3xl bg-white shadow-2xl w-full max-w-6xl border border-gray-200">
            <div class="p-8">
                <h3 class="text-lg font-semibold mb-4">Klanten per Plaats</h3>
                <p class="text-sm text-gray-400 mb-6">
                    Deze grafiek toont de verdeling van klanten over verschillende steden.
                </p>

                <!-- Fallback if no data -->
                <div v-if="Object.keys(klanten_growth_by_year).length === 0" class="text-center text-gray-500 p-6">
                    <i class="fas fa-chart-line text-gray-300 text-6xl mb-4"></i>
                    <p class="text-lg font-medium">Geen gegevens beschikbaar om de grafiek weer te geven.</p>
                </div>

                <!-- Chart -->
                <canvas v-else id="klantenPerPlaatsChart" class="max-h-screen w-full"></canvas>
            </div>
        </div>
    </div>
</template>



<script setup>
import { onMounted } from "vue";
import { Chart } from "chart.js/auto";


const props = defineProps({
    klanten_per_plaats: {
        type: Object,
        required: true,
    },
});


onMounted(() => {

    const klantenPerPlaatsChartCtx = document
        .getElementById("klantenPerPlaatsChart")
        .getContext("2d");


    const gradient = klantenPerPlaatsChartCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, "#F1487A");
    gradient.addColorStop(1, "#FFA532");


    new Chart(klantenPerPlaatsChartCtx, {
        type: "bar",
        data: {
            labels: Object.keys(props.klanten_per_plaats),
            datasets: [
                {
                    label: "Aantal Klanten",
                    data: Object.values(props.klanten_per_plaats),
                    backgroundColor: gradient,
                    borderColor: "#1A1952",
                    borderWidth: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: "top",
                    labels: {
                        color: "#1A1952",
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif",
                        },
                    },
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: "Plaatsen",
                        color: "#6B7280",
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif",
                        },
                    },
                    ticks: {
                        color: "#6B7280",
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif",
                        },
                    },
                    grid: {
                        color: "#E5E7EB",
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: "Aantal Klanten",
                        color: "#6B7280",
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif",
                        },
                    },
                    ticks: {
                        color: "#6B7280",
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif",
                        },
                    },
                    grid: {
                        color: "#E5E7EB",
                    },
                    beginAtZero: true,
                },
            },
        },
    });
});
</script>
