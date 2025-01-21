<template>
    <div class="px-8 pt-4 flex justify-center min-h-screen">

        <div class="rounded-3xl bg-white shadow-2xl w-full max-w-5xl border border-gray-200">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-4xl font-bold text-[#1A1952] tracking-tight">Leverancierskaart</h2>
                </div>
                <p class="text-sm text-gray-600 mb-4">Klik op een marker om klantdetails op de kaart te bekijken.</p>

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


const props = defineProps({
    leveranciers: Array,
});

onMounted(() => {

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: { lat: 52.028, lng: 4.901 },
    });


    const infoWindow = new google.maps.InfoWindow();


    props.leveranciers.forEach((leverancier) => {
        if (leverancier.latitude && leverancier.longitude) {
            const position = {
                lat: parseFloat(leverancier.latitude),
                lng: parseFloat(leverancier.longitude)
            };

            const marker = new google.maps.Marker({
                position: position,
                map: map,
                title: leverancier.leverancier_bedrijfsnaam,
            });


            marker.addListener("click", () => {
                infoWindow.setContent(`
                    <div class="p-2">
                        <h3 class="font-bold text-[#1A1952]">${leverancier.leverancier_bedrijfsnaam}</h3>
                        <p class="text-sm text-gray-500">Adres: ${leverancier.leverancier_adres}</p>
                        <p class="text-sm text-gray-500">Postcode: ${leverancier.leverancier_postcode}</p>
                        <p class="text-sm text-gray-500">Plaats: ${leverancier.leverancier_plaats}</p>
                        <a href="/leverancier/${leverancier.leverancier_id}"
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
