<template>
    <div class="p-6 space-y-8 min-h-screen max-w-6xl mx-auto">
        <div class="p-6 rounded-3xl bg-white shadow-md">

            <h3 class="text-lg font-semibold mb-4">Klanten per Plaats</h3>
            <p class="text-sm text-gray-400 mb-6">
                Deze grafiek toont de verdeling van klanten over verschillende steden.
            </p>
            <canvas id="klantenPerPlaatsChart" class="max-h-screen w-full"></canvas>
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
