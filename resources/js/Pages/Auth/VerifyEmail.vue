<template>
    <div class="h-full flex items-center justify-center py-6 px-6">
        <div class="card bg-white max-w-6xl w-full rounded-3xl shadow-lg py-8 px-10 text-center">
            <!-- Logo Section -->
            <div class="mb-6">
                <img
                    src="https://intranet.2befresh.nl/uploads/new-2befresh-logo-full.png"
                    alt="2BeFresh Logo"
                    class="mx-auto w-64"
                />
            </div>

            <!-- Header Section -->
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Controleer uw inbox, alstublieft!</h1>

            <!-- Message Section -->
            <p class="text-lg text-gray-600 mb-4">
                Hallo <strong>{{ user.fullName }}</strong>, om te beginnen met het gebruik van
                <strong>2BeFresh</strong>, moeten we uw e-mailadres verifiëren. We hebben de verificatielink al verzonden. Controleer uw inbox en bevestig dat u het echt bent.
            </p>
            <p class="text-sm text-gray-500 mb-6">Geen e-mail ontvangen?</p>

            <!-- Resend Button -->
            <Link
                :href="route('verification.send')"
                method="post"
                as="button"
                class="cta-button bg-gradient-to-r from-pink-500 to-orange-400 text-white font-bold py-3 px-8 rounded-full uppercase"
            >
                Verzend opnieuw
            </Link>

            <!-- Flash Message -->
            <p v-if="page.props.flash.success" class="mt-6 text-green-500 font-semibold">
                {{ page.props.flash.success }}
            </p>

            <!-- Footer Section -->
            <div class="footer mt-6 text-sm text-gray-500">
                <p>
                    Als u problemen ondervindt bij het ontvangen van de e-mail, neem dan contact op
                    met ons ondersteuningsteam via <a href="mailto:support@2befresh.nl" class="email-link text-blue-500">support@2befresh.nl</a>.
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage();
const user = computed(() => page.props.user);
</script>
