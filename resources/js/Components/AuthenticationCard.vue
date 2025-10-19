<!--js/Components/AuthenticationCard.vue-->
<script setup>
defineProps({
    background: {
        type: String,
        default: 'gradient' // gradient, plain
    }
});
</script>

<template>
    <div :class="[
        'min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 transition-all duration-300',
        background === 'gradient' 
            ? 'bg-gradient-to-br from-blue-50 via-white to-purple-50' 
            : 'bg-gray-50'
    ]">
        <!-- Logo Section -->
        <div class="mb-8 transform transition-transform duration-300 hover:scale-105">
            <slot name="logo" />
        </div>

        <!-- Card Content -->
        <div class="w-full sm:max-w-md mx-4 mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/60 overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <div class="p-8">
                    <slot />
                </div>
                
                <!-- Footer Pattern -->
                <div class="h-2 bg-gradient-to-r from-blue-500 to-purple-500"></div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="text-center text-sm text-gray-600 max-w-md mx-4 px-4">
            <p>Sistem Manajemen Nilai Siswa Modern & Terintegrasi</p>
        </div>
    </div>
</template>