<template>
    <div class="px-4 sm:px-6 lg:px-8 pt-4 flex justify-center min-h-full">
        <div class="rounded-3xl bg-white shadow-2xl w-full max-w-6xl border border-gray-200">
            <div class="p-4 sm:p-8">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <h2 class="text-2xl sm:text-4xl font-bold text-[#1A1952] tracking-tight mb-2 sm:mb-0">
                        Klantenkaart
                    </h2>
                </div>

                <!-- Description -->
                <p class="text-xs sm:text-sm text-gray-600 mb-4">
                    Klik op een marker om klantdetails op de kaart te bekijken.
                </p>

                <!-- Map Container -->
                <div
                    id="map"
                    class="rounded-2xl overflow-hidden border border-gray-300 shadow-sm h-72 sm:h-96 lg:h-[500px] xl:h-[600px]"
                    style="width: 100%;"
                ></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, defineProps} from "vue";

// Props
const props = defineProps({
    klanten: Array, // Array of customer data
});

// Function to load Google Maps API dynamically
const loadGoogleMapsApi = () => {
    return new Promise((resolve, reject) => {
        if (typeof google !== "undefined" && google.maps) {
            resolve(); // API already loaded
            return;
        }

        // Create script element for Google Maps
        const script = document.createElement("script");
        script.src =
            "https://maps.googleapis.com/maps/api/js?key=AIzaSyDGt53_sxryMkf5PmuUSoPZ5xzWswB_5Rk&callback=initMap";
        script.async = true;
        script.defer = true;

        // Handle script load and error events
        script.onload = () => resolve();
        script.onerror = () => reject(new Error("Failed to load Google Maps API."));

        document.head.appendChild(script);
    });
};

// Function to initialize the Google Map
const initMap = () => {
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: {lat: 52.028, lng: 4.901}, // Default center
    });

    // Create a reusable InfoWindow instance
    const infoWindow = new google.maps.InfoWindow();

    // Add markers for each customer
    props.klanten.forEach((klant) => {
        if (klant.latitude && klant.longitude && !klant.deleted_at) {
            const position = {
                lat: parseFloat(klant.latitude),
                lng: parseFloat(klant.longitude),
            };

            const marker = new google.maps.Marker({
                position,
                map,
                title: klant.klant_bedrijfsnaam,
            });

            // Add InfoWindow content
            marker.addListener("click", () => {
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
                infoWindow.open(map, marker);
            });
        }
    });
};

// Lifecycle hook
onMounted(async () => {
    try {
        await loadGoogleMapsApi(); // Wait for Google Maps API to load
        initMap(); // Initialize the map after API is loaded
    } catch (error) {
        console.error(error.message);
    }
});
</script>
