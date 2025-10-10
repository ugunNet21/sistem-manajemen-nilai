<!-- resources/js/Pages/Admin/Dashboard.vue -->
<script setup>
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

defineOptions({
    layout: AdminLayout
});

const stats = [
    {
        label: 'Total Siswa',
        value: '150',
        icon: 'fas fa-users',
        color: 'blue',
        trend: '+12% dari bulan lalu'
    },
    {
        label: 'Rata-rata Nilai',
        value: '76.5',
        icon: 'fas fa-chart-line',
        color: 'green',
        trend: '+3.2 poin'
    },
    {
        label: 'Total Kelas',
        value: '8',
        icon: 'fas fa-school',
        color: 'purple',
        trend: '7A, 7B, 8A, 8B, 9A, 9B...'
    },
    {
        label: 'Mata Pelajaran',
        value: '12',
        icon: 'fas fa-book',
        color: 'orange',
        trend: 'Matematika, Bahasa, IPA...'
    }
];

const nilaiData = ref([
    { id: 1, nama: 'Andi', kelas: '7A', mapel: 'Matematika', nilai: 80, grade: 'B' },
    { id: 2, nama: 'Andi', kelas: '7A', mapel: 'Bahasa', nilai: 70, grade: 'B' },
    { id: 3, nama: 'Budi', kelas: '7A', mapel: 'Matematika', nilai: 60, grade: 'C' },
    { id: 4, nama: 'Budi', kelas: '7A', mapel: 'Bahasa', nilai: 75, grade: 'B' },
    { id: 5, nama: 'Citra', kelas: '7B', mapel: 'Matematika', nilai: 90, grade: 'A' },
    { id: 6, nama: 'Citra', kelas: '7B', mapel: 'Bahasa', nilai: 85, grade: 'A' }
]);

const showAddModal = ref(false);
const showImportModal = ref(false);

const getColorClasses = (color) => {
    const classes = {
        blue: { border: 'border-blue-500', bg: 'bg-blue-100', text: 'text-blue-600' },
        green: { border: 'border-green-500', bg: 'bg-green-100', text: 'text-green-600' },
        purple: { border: 'border-purple-500', bg: 'bg-purple-100', text: 'text-purple-600' },
        orange: { border: 'border-orange-500', bg: 'bg-orange-100', text: 'text-orange-600' }
    };
    return classes[color] || classes.blue;
};

const getGradeColor = (grade) => {
    switch (grade) {
        case 'A': return 'bg-blue-100 text-blue-800';
        case 'B': return 'bg-green-100 text-green-800';
        case 'C': return 'bg-yellow-100 text-yellow-800';
        case 'D': return 'bg-red-100 text-red-800';
        default: return 'bg-gray-100 text-gray-800';
    }
};

const navigateToGrades = () => {
    router.visit(route('admin.grades.index'));
};

const exportExcel = () => {
    alert('Export Excel akan diproses...');
};
</script>

<template>
    <div>
        <Head title="Dashboard" />
        
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Overview</h1>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div
                v-for="(stat, index) in stats"
                :key="index"
                class="bg-white rounded-xl shadow-sm p-6"
                :class="`border-l-4 ${getColorClasses(stat.color).border}`"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ stat.label }}</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ stat.value }}</p>
                    </div>
                    <div 
                        class="w-12 h-12 rounded-full flex items-center justify-center"
                        :class="getColorClasses(stat.color).bg"
                    >
                        <i :class="[stat.icon, getColorClasses(stat.color).text, 'text-xl']"></i>
                    </div>
                </div>
                <p 
                    class="text-sm mt-4"
                    :class="stat.color === 'blue' || stat.color === 'green' ? 'text-green-600' : 'text-gray-500'"
                >
                    <i v-if="stat.color === 'blue' || stat.color === 'green'" class="fas fa-arrow-up"></i>
                    {{ stat.trend }}
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-800">Kelola Data Nilai</h3>
            </div>
            <div class="p-4 flex flex-wrap gap-3">
                <button 
                    @click="navigateToGrades"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg flex items-center hover:bg-blue-700 transition"
                >
                    <i class="fas fa-plus mr-2"></i> Tambah Data
                </button>
                <button 
                    @click="showImportModal = true"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg flex items-center hover:bg-green-700 transition"
                >
                    <i class="fas fa-file-import mr-2"></i> Import Excel
                </button>
                <button 
                    @click="exportExcel"
                    class="px-4 py-2 bg-purple-600 text-white rounded-lg flex items-center hover:bg-purple-700 transition"
                >
                    <i class="fas fa-file-export mr-2"></i> Export Excel
                </button>
                <button class="px-4 py-2 bg-gray-600 text-white rounded-lg flex items-center hover:bg-gray-700 transition">
                    <i class="fas fa-filter mr-2"></i> Filter Data
                </button>
            </div>
        </div>
        
        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-800">Data Nilai Siswa Terbaru</h3>
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Cari..." 
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Huruf</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr 
                            v-for="(item, index) in nilaiData" 
                            :key="item.id"
                            :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
                        >
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ item.nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.kelas }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.mapel }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">{{ item.nilai }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span 
                                    :class="[getGradeColor(item.grade), 'px-2 py-1 rounded-full text-xs font-semibold']"
                                >
                                    {{ item.grade }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">6</span> dari <span class="font-medium">6</span> hasil
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 border border-gray-300 rounded-md bg-white text-gray-500 hover:bg-gray-50 transition">
                        Sebelumnya
                    </button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md bg-blue-600 text-white">
                        1
                    </button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md bg-white text-gray-500 hover:bg-gray-50 transition">
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Chart 1: Distribusi Nilai -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Distribusi Nilai Matematika</h3>
                <div class="h-64 flex items-end justify-between px-8">
                    <div class="flex flex-col items-center">
                        <div class="w-12 bg-blue-500 rounded-t" style="height: 120px;"></div>
                        <span class="mt-2 text-sm text-gray-600">A (90)</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-12 bg-green-500 rounded-t" style="height: 80px;"></div>
                        <span class="mt-2 text-sm text-gray-600">B (80)</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-12 bg-yellow-500 rounded-t" style="height: 60px;"></div>
                        <span class="mt-2 text-sm text-gray-600">C (60)</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-12 bg-red-500 rounded-t" style="height: 0px;"></div>
                        <span class="mt-2 text-sm text-gray-600">D (0)</span>
                    </div>
                </div>
            </div>
            
            <!-- Chart 2: Rata-rata per Mapel -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Rata-rata Nilai per Mapel</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-1 text-sm">
                            <span class="text-gray-600">Matematika</span>
                            <span class="font-medium text-gray-800">76.7</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 76.7%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-1 text-sm">
                            <span class="text-gray-600">Bahasa Indonesia</span>
                            <span class="font-medium text-gray-800">76.7</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-green-600 h-2.5 rounded-full" style="width: 76.7%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-1 text-sm">
                            <span class="text-gray-600">IPA</span>
                            <span class="font-medium text-gray-800">82.3</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-purple-600 h-2.5 rounded-full" style="width: 82.3%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-1 text-sm">
                            <span class="text-gray-600">IPS</span>
                            <span class="font-medium text-gray-800">78.9</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-orange-600 h-2.5 rounded-full" style="width: 78.9%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal: Import Excel -->
        <div v-if="showImportModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div @click="showImportModal = false" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
                
                <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Import Data Excel</h3>
                        <button @click="showImportModal = false" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 mb-2">Klik atau drag & drop file Excel</p>
                            <p class="text-sm text-gray-500">Format: .xlsx, .xls (Max 5MB)</p>
                            <input type="file" accept=".xlsx,.xls" class="hidden">
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-sm text-blue-800 font-medium mb-2">Format Excel:</p>
                            <p class="text-xs text-blue-600">Kolom: No | Nama | Kelas | Mapel | Nilai</p>
                        </div>
                        
                        <div class="flex space-x-3">
                            <button 
                                @click="showImportModal = false" 
                                class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
                            >
                                Batal
                            </button>
                            <button class="flex-1 px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                Import
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>