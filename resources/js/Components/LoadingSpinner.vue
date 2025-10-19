<!--js/Components/LoadingSpinner.vue-->
<template>
    <div class="flex items-center justify-center space-x-2">
        <div class="animate-spin rounded-full h-4 w-4 border-2 border-blue-600 border-t-transparent"></div>
        <span class="text-sm text-gray-600"><slot>Memuat...</slot></span>
    </div>
</template>