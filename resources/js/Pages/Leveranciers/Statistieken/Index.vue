<template>
    <div class="p-6 space-y-8 min-h-screen max-w-7xl mx-auto">
        <!-- Container voor de grafieksectie -->
        <div class="p-6 rounded-3xl bg-white shadow-md">
            <!-- Grafiektitel -->
            <h3 class="text-lg font-semibold mb-4">Leveranciers per Plaats</h3>
            <!-- Beschrijving van de grafiek -->
            <p class="text-sm text-gray-400 mb-6">
                Deze grafiek toont de verdeling van leveranciers over verschillende steden.
            </p>
            <!-- Canvas-element voor het weergeven van de grafiek -->
            <canvas id="leveranciersPerPlaatsChart" class="max-h-screen w-full"></canvas>
        </div>
    </div>
</template>

<script setup>
import {onMounted} from "vue"; // Lifecycle hook voor code die moet worden uitgevoerd nadat de component is geladen
import {Chart} from "chart.js/auto"; // Importeren van de Chart.js-bibliotheek

// Definiëren van de props die naar deze component worden doorgegeven
const props = defineProps({
    leveranciers_per_plaats: {
        type: Object, // Verwacht een object dat stadsnamen aan aantal leveranciers koppelt
        required: true, // Deze prop is verplicht
    },
});

// Lifecycle hook om de grafiek te initialiseren nadat de DOM is geladen
onMounted(() => {
    // Toegang tot het canvas-element voor het weergeven van de grafiek
    const leveranciersPerPlaatsChartCtx = document
        .getElementById("leveranciersPerPlaatsChart")
        .getContext("2d");

    // Maak een gradient voor de grafiekbalken
    const gradient = leveranciersPerPlaatsChartCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, "#F1487A"); // Startkleur van de gradient
    gradient.addColorStop(1, "#FFA532"); // Eindkleur van de gradient

    // Initialiseren van een nieuwe Chart.js staafgrafiek
    new Chart(leveranciersPerPlaatsChartCtx, {
        type: "bar", // Type grafiek: staafgrafiek
        data: {
            labels: Object.keys(props.leveranciers_per_plaats), // X-as labels (stadsnamen)
            datasets: [
                {
                    label: "Aantal Leveranciers", // Label voor de dataset
                    data: Object.values(props.leveranciers_per_plaats), // Y-as data (aantal leveranciers)
                    backgroundColor: gradient, // Gebruik de gradient voor de balken
                    borderColor: "#1A1952", // Randkleur van de balken
                    borderWidth: 2, // Breedte van de balkranden
                },
            ],
        },
        options: {
            responsive: true, // Maak de grafiek responsief
            maintainAspectRatio: false, // Sta dynamische schaal toe
            plugins: {
                legend: {
                    display: true, // Toon de legenda
                    position: "top", // Positie van de legenda
                    labels: {
                        color: "#1A1952", // Tekstkleur voor de legenda
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif", // Lettertype voor de legenda
                        },
                    },
                },
            },
            scales: {
                x: {
                    title: {
                        display: true, // Toon titel voor de X-as
                        text: "Plaatsen", // Titeltekst voor de X-as
                        color: "#6B7280", // Tekstkleur voor de titel van de X-as
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif", // Lettertype voor de titel van de X-as
                        },
                    },
                    ticks: {
                        color: "#6B7280", // Tekstkleur voor de ticks op de X-as
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif", // Lettertype voor de ticks op de X-as
                        },
                    },
                    grid: {
                        color: "#E5E7EB", // Kleur van de rasterlijnen op de X-as
                    },
                },
                y: {
                    title: {
                        display: true, // Toon titel voor de Y-as
                        text: "Aantal Leveranciers", // Titeltekst voor de Y-as
                        color: "#6B7280", // Tekstkleur voor de titel van de Y-as
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif", // Lettertype voor de titel van de Y-as
                        },
                    },
                    ticks: {
                        color: "#6B7280", // Tekstkleur voor de ticks op de Y-as
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif", // Lettertype voor de ticks op de Y-as
                        },
                    },
                    grid: {
                        color: "#E5E7EB", // Kleur van de rasterlijnen op de Y-as
                    },
                    beginAtZero: true, // Zorg ervoor dat de Y-as begint bij 0
                },
            },
        },
    });
});
</script>
