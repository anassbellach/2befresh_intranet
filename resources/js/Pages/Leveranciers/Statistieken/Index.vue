<template>
    <div class="p-6 space-y-8 min-h-screen max-w-7xl mx-auto">
        <!-- Container for the charts section -->
        <div class="p-6 rounded-3xl bg-white shadow-md">
            <!-- Chart title -->
            <h3 class="text-lg font-semibold mb-4">Leveranciers per Plaats</h3>
            <!-- Description of the chart -->
            <p class="text-sm text-gray-400 mb-6">
                This chart shows the distribution of leevranciers across different cities.
            </p>
            <!-- Canvas element for rendering the chart -->
            <canvas id="leveranciersPerPlaatsChart" class="max-h-screen w-full"></canvas>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue"; // Lifecycle hook for code to run after the component is mounted
import { Chart } from "chart.js/auto"; // Importing Chart.js library

// Defining the props passed into this component
const props = defineProps({
    leveranciers_per_plaats: {
        type: Object, // Expecting an object mapping city names to klant numbers
        required: true, // This prop is required
    },
});

// Lifecycle hook to initialize the chart after the DOM is mounted
onMounted(() => {
    // Access the canvas element for rendering the chart
    const leveranciersPerPlaatsChartCtx = document
        .getElementById("leveranciersPerPlaatsChart")
        .getContext("2d");

    // Create a gradient for the chart bars
    const gradient = leveranciersPerPlaatsChartCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, "#F1487A"); // Starting color of the gradient
    gradient.addColorStop(1, "#FFA532"); // Ending color of the gradient

    // Initialize a new Chart.js bar chart
    new Chart(leveranciersPerPlaatsChartCtx, {
        type: "bar", // Type of chart: bar chart
        data: {
            labels: Object.keys(props.leveranciers_per_plaats), // X-axis labels (city names)
            datasets: [
                {
                    label: "Number of Leveranciers", // Label for the dataset
                    data: Object.values(props.leveranciers_per_plaats), // Y-axis data (number of klanten)
                    backgroundColor: gradient, // Use the gradient for the bars
                    borderColor: "#1A1952", // Border color for the bars
                    borderWidth: 2, // Width of the bar borders
                },
            ],
        },
        options: {
            responsive: true, // Make the chart responsive
            maintainAspectRatio: false, // Allow dynamic resizing
            plugins: {
                legend: {
                    display: true, // Display the legend
                    position: "top", // Position of the legend
                    labels: {
                        color: "#1A1952", // Text color for the legend
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif", // Font family for the legend
                        },
                    },
                },
            },
            scales: {
                x: {
                    title: {
                        display: true, // Display title for the X-axis
                        text: "Plaatsen", // Title text for the X-axis
                        color: "#6B7280", // Text color for the X-axis title
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif", // Font family for the X-axis title
                        },
                    },
                    ticks: {
                        color: "#6B7280", // Text color for the X-axis ticks
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif", // Font family for the X-axis ticks
                        },
                    },
                    grid: {
                        color: "#E5E7EB", // Color of the grid lines on the X-axis
                    },
                },
                y: {
                    title: {
                        display: true, // Display title for the Y-axis
                        text: "Number of Leveranciers", // Title text for the Y-axis
                        color: "#6B7280", // Text color for the Y-axis title
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif", // Font family for the Y-axis title
                        },
                    },
                    ticks: {
                        color: "#6B7280", // Text color for the Y-axis ticks
                        font: {
                            family: "Helvetica Neue, Arial, sans-serif", // Font family for the Y-axis ticks
                        },
                    },
                    grid: {
                        color: "#E5E7EB", // Color of the grid lines on the Y-axis
                    },
                    beginAtZero: true, // Ensure the Y-axis starts at 0
                },
            },
        },
    });
});
</script>
