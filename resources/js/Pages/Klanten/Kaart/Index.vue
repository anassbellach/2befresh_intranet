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

                <!-- Map Container with Responsive Height Using Tailwind CSS -->
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
import { onMounted, defineProps } from "vue";

const props = defineProps({
    klanten: Array,
});

onMounted(() => {
    // Initialize the Google Map
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: { lat: 52.028, lng: 4.901 }, // Default center
    });

    // Create a single InfoWindow instance to reuse
    const infoWindow = new google.maps.InfoWindow();

    // Add markers for each customer
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
});

</script>
