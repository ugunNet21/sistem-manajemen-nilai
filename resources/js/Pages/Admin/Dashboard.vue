<!-- resources/js/Pages/Admin/Dashboard.vue -->
<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed } from 'vue';

import StatCard from '@/Components/Admin/Dashboard/StatCard.vue';
import GradeDistributionChart from '@/Components/Admin/Dashboard/GradeDistributionChart.vue';
import AverageBySubjectChart from '@/Components/Admin/Dashboard/AverageBySubjectChart.vue';

import ModalForm from '@/Pages/Admin/Grades/ModalForm.vue';
import ModalImportExcel from '@/Pages/Admin/Grades/ModalImportExcel.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    stats: Object,
    gradeDistribution: Array,
    averageBySubject: Array,
    recentGrades: Array,
    students: Array,
});

const showFormModal = ref(false);
const showImportModal = ref(false);
const gradeToEdit = ref(null);
const isExporting = ref(false);

const statsData = computed(() => [
    { label: 'Total Siswa', value: props.stats.total_siswa, icon: 'fas fa-users', color: 'blue' },
    { label: 'Rata-rata Nilai', value: parseFloat(props.stats.rata_rata_nilai).toFixed(1), icon: 'fas fa-chart-line', color: 'green' },
    { label: 'Total Kelas', value: props.stats.total_kelas, icon: 'fas fa-school', color: 'purple' },
    { label: 'Total Mapel', value: props.stats.total_mapel, icon: 'fas fa-book', color: 'orange' },
]);

// Build query string untuk export URL
const getExportUrl = () => {
    return route('grades.export');
};

const openEditModal = (grade) => {
    gradeToEdit.value = grade;
    showFormModal.value = true;
};

const deleteGrade = (grade) => {
    if (confirm(`Hapus nilai ${grade.mapel} untuk ${grade.siswa.nama}?`)) {
        router.delete(route('admin.grades.destroy', grade.id), {
            preserveScroll: true,
        });
    }
};

const gradeBadgeClass = (grade) => ({
    'bg-green-100 text-green-800': grade === 'A',
    'bg-blue-100 text-blue-800': grade === 'B',
    'bg-yellow-100 text-yellow-800': grade === 'C',
    'bg-red-100 text-red-800': grade === 'D',
});

// Handle export click
const handleExport = () => {
    isExporting.value = true;
    setTimeout(() => { isExporting.value = false; }, 2000);
};
</script>

<template>
    <div>

        <Head title="Dashboard" />
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Overview</h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <StatCard v-for="stat in statsData" :key="stat.label" v-bind="stat" />
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <GradeDistributionChart :data="gradeDistribution" />
            <AverageBySubjectChart :data="averageBySubject" />
        </div>

        <!-- Recent Grades Table & Actions -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div
                class="p-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h3 class="text-lg font-medium text-gray-800">Data Nilai Terbaru</h3>
                <div class="flex flex-wrap gap-3">
                    <button @click="showFormModal = true"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tambah Nilai
                    </button>
                    <button @click="showImportModal = true"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm inline-flex items-center">
                        <i class="fas fa-file-import mr-2"></i> Import
                    </button>
                    <a :href="getExportUrl()" @click="handleExport"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm inline-flex items-center disabled:opacity-50"
                        :class="{ 'cursor-not-allowed': isExporting }">
                        <i v-if="!isExporting" class="fas fa-file-export mr-2"></i>
                        <i v-else class="fas fa-spinner fa-spin mr-2"></i>
                        {{ isExporting ? 'Mendownload...' : 'Export Excel' }}
                    </a>
                    <Link :href="route('admin.grades.index')"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm inline-flex items-center">
                    <i class="fas fa-tasks mr-2"></i> Kelola Semua
                    </Link>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mapel</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nilai</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Grade</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="item in recentGrades" :key="item.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ item.siswa.nama
                                }} <span class="text-gray-500">({{ item.siswa.kelas }})</span></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.mapel }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-semibold text-gray-800">{{
                                item.nilai }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 rounded-full text-xs font-bold"
                                    :class="gradeBadgeClass(item.grade)">{{ item.grade }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <button @click="openEditModal(item)" class="text-blue-600 hover:text-blue-900 mr-3"
                                    title="Edit"><i class="fas fa-edit"></i></button>
                                <button @click="deleteGrade(item)" class="text-red-600 hover:text-red-900"
                                    title="Hapus"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr v-if="recentGrades.length === 0">
                            <td colspan="5" class="text-center py-8 text-gray-500">Belum ada data nilai.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Reusable Modals -->
        <ModalForm :show="showFormModal" :students="students" :grade="gradeToEdit"
            @close="showFormModal = false; gradeToEdit = null" />
        <ModalImportExcel :show="showImportModal" @close="showImportModal = false" />
    </div>
</template>