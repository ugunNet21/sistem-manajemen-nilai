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
];

const navigateTo = (item) => {
    emit('update:currentPage', item.id);
    emit('close-sidebar');
    router.visit(route(item.route));
};

const linkClass = (id) => [
    'flex items-center space-x-3 px-4 py-3 rounded-lg cursor-pointer transition',
    props.currentPage === id ? 'bg-blue-700' : 'hover:bg-blue-700'
];

const logout = () => router.post(route('logout'));
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
            <!-- Dashboard -->
            <a v-if="$page.props.can?.['view-dashboard']" @click="navigateTo(menuItems[0])"
                :class="linkClass('dashboard')">
                <i :class="[menuItems[0].icon, 'w-5']"></i>
                <span>{{ menuItems[0].label }}</span>
            </a>

            <!-- Data Siswa -->
            <a v-if="$page.props.can?.['manage-siswa']" @click="navigateTo(menuItems[1])" :class="linkClass('siswa')">
                <i :class="[menuItems[1].icon, 'w-5']"></i>
                <span>{{ menuItems[1].label }}</span>
            </a>

            <!-- Data Nilai -->
            <a v-if="$page.props.can?.['manage-nilai']" @click="navigateTo(menuItems[2])" :class="linkClass('nilai')">
                <i :class="[menuItems[2].icon, 'w-5']"></i>
                <span>{{ menuItems[2].label }}</span>
            </a>

            <!-- Import / Export Excel -->
            <a v-if="$page.props.can?.['import-excel']" @click="navigateTo(menuItems[3])" :class="linkClass('laporan')">
                <i :class="[menuItems[3].icon, 'w-5']"></i>
                <span>{{ menuItems[3].label }}</span>
            </a>
            <a v-if="$page.props.can?.['export-excel']" @click="navigateTo(menuItems[4])"
                :class="linkClass('settings')">
                <i :class="[menuItems[4].icon, 'w-5']"></i>
                <span>{{ menuItems[4].label }}</span>
            </a>

            <!-- Lihat Situs -->
            <a :href="'/'" target="_blank"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-globe w-5"></i>
                <span>Lihat Situs</span>
            </a>

            <!-- Logout -->
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
