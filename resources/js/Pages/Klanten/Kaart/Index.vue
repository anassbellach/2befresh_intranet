<template>
    <div class="px-8 pt-4 flex justify-center min-h-screen">

        <!-- Kaartkaart -->
        <div class="rounded-3xl bg-white shadow-2xl w-full max-w-5xl border border-gray-200">
            <div class="p-8">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-4xl font-bold text-[#1A1952] tracking-tight">Klantenkaart</h2>
                    <button
                        class="px-4 py-2 bg-[#1A1952] text-white rounded-full shadow hover:bg-[#141341] focus:outline-none focus:ring-4 focus:ring-[#1A1952]/30 transition">
                        Kaart Verversen
                    </button>
                </div>
                <p class="text-sm text-gray-600 mb-4">Klik op een marker om klantdetails op de kaart te bekijken.</p>

                <!-- Kaartcontainer -->
                <div
                    id="map"
                    class="rounded-2xl overflow-hidden border border-gray-300 shadow-sm"
                    style="height: 500px; width: 100%;">
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { onMounted, defineProps } from "vue";

// Props om de 'klanten'-data van de controller te accepteren
const props = defineProps({
    klanten: Array, // Accepteer de klanten-array
});

onMounted(() => {
    // Attach the function to the global window object
    window.initMap = () => {
        // Initialize the Google Map
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            center: { lat: 52.028, lng: 4.901 }, // Default center (adjust dynamically if needed)
        });

        // Create a single InfoWindow instance for reuse
        const infoWindow = new google.maps.InfoWindow();

        // Place markers for each customer
        props.klanten.forEach((klant) => {
            if (klant.latitude && klant.longitude && !klant.deleted_at) {
                const position = {
                    lat: parseFloat(klant.latitude),
                    lng: parseFloat(klant.longitude),
                };

                const marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: klant.klant_bedrijfsnaam,
                });

                // Show InfoWindow on marker click
                marker.addListener("click", () => {
                    // Set the content of the InfoWindow
                    infoWindow.setContent(`
                        <div class="p-2">
                            <h3 class="font-bold text-lg text-[#1A1952]">${klant.klant_bedrijfsnaam}</h3>
                            <p class="text-sm text-gray-500">Adres: ${klant.klant_adres}</p>
                            <p class="text-sm text-gray-500">Postcode: ${klant.klant_postcode}</p>
                            <p class="text-sm text-gray-500">Plaats: ${klant.klant_plaats}</p>
                            <a href="/klant/${klant.klant_id}"
                               target="_blank"
                               class="mt-2 inline-block px-4 py-2 bg-[#1A1952] text-white text-sm rounded-full shadow-md transform hover:scale-105 hover:shadow-lg transition duration-200">
                               Bekijk Details
                            </a>
                        </div>
                    `);

                    // Open the InfoWindow for the clicked marker
                    infoWindow.open(map, marker);
                });
            }
        });
    };
});


</script>
