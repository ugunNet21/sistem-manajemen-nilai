<!-- resources/js/Components/Admin/AdminSidebar.vue -->
<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
    sidebarOpen: Boolean,
    currentPage: String
});

const emit = defineEmits(['update:currentPage', 'close-sidebar']);

const menuItems = [
    { id: 'dashboard', label: 'Dashboard', icon: 'fas fa-chart-line', route: 'dashboard' },
    { id: 'siswa', label: 'Data Siswa', icon: 'fas fa-users', route: 'admin.students.index' },
    { id: 'nilai', label: 'Data Nilai', icon: 'fas fa-clipboard-list', route: 'admin.grades.index' },
    { id: 'laporan', label: 'Laporan', icon: 'fas fa-file-alt', route: 'admin.reports.index' },
    { id: 'settings', label: 'Pengaturan', icon: 'fas fa-cog', route: 'admin.settings.index' },
    { id: 'home', label: 'Lihat Situs', icon: 'fas fa-globe', url: '/', external: true },
];

const navigateTo = (item) => {
    emit('update:currentPage', item.id);
    emit('close-sidebar');
    router.visit(route(item.route));
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <aside :class="[
        'fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white transition-transform duration-300',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full',
        'lg:translate-x-0'
    ]">

        <div class="flex items-center justify-between p-6 border-b border-blue-700">
            <div class="flex items-center space-x-3">
                <i class="fas fa-graduation-cap text-2xl"></i>
                <span class="text-xl font-bold">SistemNilai</span>
            </div>
            <button @click="$emit('close-sidebar')" class="lg:hidden">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <nav class="p-4 space-y-2">
            <template v-for="item in menuItems" :key="item.id">
                <!-- Jika item external, gunakan <a> biasa -->
                <a v-if="item.external" :href="item.url" target="_blank" rel="noopener noreferrer"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg cursor-pointer hover:bg-blue-700 transition">
                    <i :class="[item.icon, 'w-5']"></i>
                    <span>{{ item.label }}</span>
                </a>

                <!-- Jika bukan external, pakai router -->
                <a v-else @click="navigateTo(item)"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg cursor-pointer transition"
                    :class="currentPage === item.id ? 'bg-blue-700' : 'hover:bg-blue-700'">
                    <i :class="[item.icon, 'w-5']"></i>
                    <span>{{ item.label }}</span>
                </a>
            </template>

            <div class="pt-4 border-t border-blue-700 mt-4">
                <a @click="logout"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg cursor-pointer hover:bg-red-600 transition">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </a>
            </div>
        </nav>
    </aside>
</template>