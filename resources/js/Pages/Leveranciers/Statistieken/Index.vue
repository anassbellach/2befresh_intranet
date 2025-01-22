<template>
    <div class="px-8 pt-4 flex justify-center min-h-full">
        <div class="rounded-3xl bg-white shadow-2xl w-full max-w-6xl border border-gray-200">
            <div class="p-8">
                <h3 class="text-lg font-semibold mb-4">Leveranciers per Plaats</h3>
                <p class="text-sm text-gray-400 mb-6">
                    Deze grafiek toont de verdeling van leveranciers over verschillende steden.
                </p>
                <canvas id="leveranciersPerPlaatsChart" class="max-h-screen w-full"></canvas>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted} from "vue";
import {Chart} from "chart.js/auto";


const props = defineProps({
    leveranciers_per_plaats: {
        type: Object,
        required: true,
    },
});


onMounted(() => {
    const leveranciersPerPlaatsChartCtx = document
        .getElementById("leveranciersPerPlaatsChart")
        .getContext("2d");

    const gradient = leveranciersPerPlaatsChartCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, "#F1487A");
    gradient.addColorStop(1, "#FFA532");

    new Chart(leveranciersPerPlaatsChartCtx, {
        type: "bar",
        data: {
            labels: Object.keys(props.leveranciers_per_plaats),
            datasets: [
                {
                    label: "Aantal Leveranciers",
                    data: Object.values(props.leveranciers_per_plaats),
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
                        text: "Aantal Leveranciers",
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
