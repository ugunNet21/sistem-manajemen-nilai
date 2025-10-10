<!-- resources/js/Layouts/AdminLayout.vue -->
<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdminSidebar from '@/Components/Admin/AdminSidebar.vue';
import AdminHeader from '@/Components/Admin/AdminHeader.vue';
import FlashMessage from '@/Components/Admin/FlashMessage.vue';

const sidebarOpen = ref(false);
const currentPage = ref('dashboard');

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

defineExpose({
    sidebarOpen,
    currentPage,
    toggleSidebar
});
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <Head>
            <title>Admin Dashboard - Sistem Nilai Siswa</title>
        </Head>
        
        <FlashMessage />
        
        <!-- Sidebar -->
        <AdminSidebar 
            :sidebar-open="sidebarOpen" 
            :current-page="currentPage"
            @update:current-page="currentPage = $event"
            @close-sidebar="sidebarOpen = false"
        />

        <!-- Main Content -->
        <div class="lg:ml-64">
            <!-- Top Navigation -->
            <AdminHeader 
                @toggle-sidebar="toggleSidebar"
            />
            
            <!-- Page Content -->
            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>