<!-- resources/js/Components/Admin/AdminHeader.vue -->
<script setup>
defineEmits(['toggle-sidebar']);
</script>

<template>
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="flex items-center justify-between px-6 py-4">
            <button @click="$emit('toggle-sidebar')" class="lg:hidden">
                <i class="fas fa-bars text-2xl text-gray-700"></i>
            </button>
            
            <div class="flex-1 max-w-2xl mx-4">
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Cari siswa, nilai, atau kelas..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <button class="relative p-2 hover:bg-gray-100 rounded-full">
                    <i class="fas fa-bell text-xl text-gray-600"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                
                <div class="flex items-center space-x-3 border-l pl-4">
                    <img 
                        src="https://ui-avatars.com/api/?name=Admin+User&background=3B82F6&color=fff" 
                        class="w-10 h-10 rounded-full"
                        alt="Admin User"
                    >
                    <div class="hidden md:block">
                        <p class="text-sm font-semibold text-gray-800">Admin User</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>