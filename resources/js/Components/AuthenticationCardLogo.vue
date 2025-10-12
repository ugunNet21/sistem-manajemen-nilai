<!--js/Components/AuthenticationCardLogo.vue-->
<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link :href="'/'" class="flex items-center space-x-3 group">
        <!-- Icon dengan gradient -->
        <div class="relative">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                <i class="fas fa-graduation-cap text-white text-xl"></i>
            </div>
            <!-- Efek ping animasi -->
            <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 animate-ping opacity-20"></div>
        </div>
        
        <!-- Teks -->
        <div class="text-left">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                SistemNilai
            </h1>
            <p class="text-xs text-gray-500 font-medium">Platform Nilai Digital</p>
        </div>
    </Link>
</template>