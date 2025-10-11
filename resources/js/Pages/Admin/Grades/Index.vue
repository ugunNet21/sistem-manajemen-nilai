<!-- resources/js/Pages/Admin/Grades/Index.vue -->
<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, reactive, watch } from 'vue';
import ModalForm from './ModalForm.vue';
import ModalImportExcel from './ModalImportExcel.vue';
import { debounce } from 'lodash';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    grades: Object,
    students: Array,
    filters: Object,
    unique: Object,
});

const showFormModal = ref(false);
const showImportModal = ref(false);
const gradeToEdit = ref(null);
const isExporting = ref(false);

const filters = reactive({
    kelas: props.filters.kelas || '',
    mapel: props.filters.mapel || '',
    grade: props.filters.grade || '',
});

// Build query string untuk export URL
const getExportUrl = () => {
    const params = new URLSearchParams();
    if (filters.kelas) params.append('kelas', filters.kelas);
    if (filters.mapel) params.append('mapel', filters.mapel);
    if (filters.grade) params.append('grade', filters.grade);
    return route('grades.export') + (params.toString() ? '?' + params.toString() : '');
};

watch(filters, debounce(() => {
    router.get(route('admin.grades.index'), filters, {
        preserveState: true,
        replace: true,
    });
}, 300));

const openAddModal = () => {
    gradeToEdit.value = null;
    showFormModal.value = true;
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
    // Reset loading setelah 2 detik
    setTimeout(() => { isExporting.value = false; }, 2000);
};
</script>

<template>
    <div>
        <Head title="Data Nilai" />
       
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Data Nilai Siswa</h1>
            <div class="flex flex-wrap gap-3">
                <button @click="showImportModal = true" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-sm inline-flex items-center">
                    <i class="fas fa-file-import mr-2"></i>Import Excel
                </button>
                <a :href="getExportUrl()" @click="handleExport" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm inline-flex items-center disabled:opacity-50"
                   :class="{ 'cursor-not-allowed': isExporting }">
                    <i v-if="!isExporting" class="fas fa-file-export mr-2"></i>
                    <i v-else class="fas fa-spinner fa-spin mr-2"></i>
                    {{ isExporting ? 'Mendownload...' : 'Export Excel' }}
                </a>
                <button @click="openAddModal" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition shadow-sm inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>Tambah Nilai
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <select v-model="filters.kelas" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <option value="">Semua Kelas</option>
                    <option v-for="kelas in unique.kelas" :key="kelas" :value="kelas">{{ kelas }}</option>
                </select>
                <select v-model="filters.mapel" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <option value="">Semua Mapel</option>
                    <option v-for="mapel in unique.mapel" :key="mapel" :value="mapel">{{ mapel }}</option>
                </select>
                <select v-model="filters.grade" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <option value="">Semua Grade</option>
                    <option value="A">A (85-100)</option>
                    <option value="B">B (70-84)</option>
                    <option value="C">C (60-69)</option>
                    <option value="D">D (<60)</option>
                </select>
            </div>
        </div>
       
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Mapel</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nilai</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Grade</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody v-if="grades.data.length > 0" class="divide-y divide-gray-200">
                        <tr v-for="(item, index) in grades.data" :key="item.id" class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ grades.from + index }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ item.siswa.nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ item.siswa.kelas }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ item.mapel }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ item.nilai }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold" :class="gradeBadgeClass(item.grade)">{{ item.grade }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <button @click="openEditModal(item)" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition" title="Edit"><i class="fas fa-edit"></i></button>
                                    <button @click="deleteGrade(item)" class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition" title="Hapus"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                     <tbody v-else>
                        <tr><td colspan="7" class="text-center py-12 text-gray-500">Belum ada data nilai.</td></tr>
                    </tbody>
                </table>
            </div>

            <div v-if="grades.links.length > 3" class="p-4 border-t">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <p class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ grades.from }}</span> - <span class="font-medium">{{ grades.to }}</span> dari <span class="font-medium">{{ grades.total }}</span> hasil
                    </p>
                    <div class="flex items-center space-x-1">
                        <template v-for="(link, index) in grades.links" :key="index">
                            <Link v-if="link.url" :href="link.url" v-html="link.label" class="px-3 py-2 text-sm rounded-md" :class="{'bg-purple-600 text-white': link.active, 'bg-white hover:bg-gray-100 border': !link.active}"/>
                            <span v-else v-html="link.label" class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-md border cursor-not-allowed"/>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <ModalForm :show="showFormModal" :students="students" :grade="gradeToEdit" @close="showFormModal = false" />
        <ModalImportExcel :show="showImportModal" @close="showImportModal = false" />
    </div>
</template>