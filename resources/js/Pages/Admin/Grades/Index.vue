<!-- resources/js/Pages/Admin/Grades/Index.vue -->
<script setup>
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, reactive } from 'vue';

defineOptions({
    layout: AdminLayout
});

const showAddModal = ref(false);
const showImportModal = ref(false);

const formData = reactive({
    siswa_id: '',
    mapel: '',
    nilai: ''
});

const nilaiData = ref([
    { id: 1, nama: 'Andi', kelas: '7A', mapel: 'Matematika', nilai: 80, grade: 'B' },
    { id: 2, nama: 'Andi', kelas: '7A', mapel: 'Bahasa', nilai: 70, grade: 'B' },
    { id: 3, nama: 'Budi', kelas: '7A', mapel: 'Matematika', nilai: 60, grade: 'C' },
    { id: 4, nama: 'Budi', kelas: '7A', mapel: 'Bahasa', nilai: 75, grade: 'B' },
    { id: 5, nama: 'Citra', kelas: '7B', mapel: 'Matematika', nilai: 90, grade: 'A' },
    { id: 6, nama: 'Citra', kelas: '7B', mapel: 'Bahasa', nilai: 85, grade: 'A' }
]);

const siswaData = ref([
    { id: 1, nama: 'Andi', kelas: '7A', jumlah_nilai: 2, rata_rata: 75 },
    { id: 2, nama: 'Budi', kelas: '7A', jumlah_nilai: 2, rata_rata: 67.5 },
    { id: 3, nama: 'Citra', kelas: '7B', jumlah_nilai: 2, rata_rata: 87.5 }
]);

const saveNilai = () => {
    // Get selected siswa data
    const siswa = siswaData.value.find(s => s.id == formData.siswa_id);
    
    // Calculate grade
    let grade = 'D';
    if (formData.nilai >= 85) grade = 'A';
    else if (formData.nilai >= 70) grade = 'B';
    else if (formData.nilai >= 60) grade = 'C';
    
    // Add to nilaiData
    nilaiData.value.push({
        id: nilaiData.value.length + 1,
        nama: siswa.nama,
        kelas: siswa.kelas,
        mapel: formData.mapel,
        nilai: parseInt(formData.nilai),
        grade: grade
    });
    
    // Reset form and close modal
    Object.assign(formData, { siswa_id: '', mapel: '', nilai: '' });
    showAddModal.value = false;
    
    alert('Data nilai berhasil ditambahkan!');
};

const editNilai = (item) => {
    Object.assign(formData, item);
    showAddModal.value = true;
};

const deleteNilai = (item) => {
    if (confirm(`Hapus nilai ${item.mapel} untuk ${item.nama}?`)) {
        const index = nilaiData.value.findIndex(n => n.id === item.id);
        if (index > -1) {
            nilaiData.value.splice(index, 1);
            alert('Data berhasil dihapus!');
        }
    }
};

const exportExcel = () => {
    alert('Export Excel akan diproses...\nFormat: No | Nama | Kelas | Mapel | Nilai');
};
</script>

<template>
    <div>
        <Head title="Data Nilai" />
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Data Nilai Siswa</h1>
            
            <div class="flex flex-wrap gap-3">
                <button @click="showImportModal = true" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-file-import mr-2"></i>Import Excel
                </button>
                <button @click="exportExcel()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-file-export mr-2"></i>Export Excel
                </button>
                <button @click="showAddModal = true" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Nilai
                </button>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua Kelas</option>
                    <option>7A</option>
                    <option>7B</option>
                    <option>8A</option>
                </select>
                
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua Mapel</option>
                    <option>Matematika</option>
                    <option>Bahasa Indonesia</option>
                    <option>IPA</option>
                </select>
                
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua Grade</option>
                    <option>A (85-100)</option>
                    <option>B (70-84)</option>
                    <option>C (60-69)</option>
                    <option>D (<60)</option>
                </select>
                
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </div>
        
        <!-- Table -->
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
                    <tbody class="divide-y divide-gray-200">
                        <tr 
                            v-for="(item, index) in nilaiData" 
                            :key="index"
                            class="hover:bg-gray-50 transition"
                        >
                            <td class="px-6 py-4 text-sm text-gray-800">{{ index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ item.nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ item.kelas }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ item.mapel }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ item.nilai }}</td>
                            <td class="px-6 py-4">
                                <span 
                                    :class="{
                                        'bg-green-100 text-green-800': item.grade === 'A',
                                        'bg-blue-100 text-blue-800': item.grade === 'B',
                                        'bg-yellow-100 text-yellow-800': item.grade === 'C',
                                        'bg-red-100 text-red-800': item.grade === 'D'
                                    }" 
                                    class="px-3 py-1 rounded-full text-xs font-semibold"
                                >
                                    {{ item.grade }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <button @click="editNilai(item)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="deleteNilai(item)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">Menampilkan 1-6 dari 6 data</p>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Previous</button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">1</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">2</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Next</button>
                </div>
            </div>
        </div>

        <!-- Modal: Add/Edit Nilai -->
        <div v-if="showAddModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div @click="showAddModal = false" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
                
                <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Tambah Nilai Siswa</h3>
                        <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <form @submit.prevent="saveNilai" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Siswa</label>
                            <select v-model="formData.siswa_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Siswa</option>
                                <option 
                                    v-for="siswa in siswaData" 
                                    :key="siswa.id" 
                                    :value="siswa.id"
                                >
                                    {{ siswa.nama }} ({{ siswa.kelas }})
                                </option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran</label>
                            <select v-model="formData.mapel" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Mata Pelajaran</option>
                                <option>Matematika</option>
                                <option>Bahasa Indonesia</option>
                                <option>Bahasa Inggris</option>
                                <option>IPA</option>
                                <option>IPS</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nilai (0-100)</label>
                            <input 
                                type="number" 
                                v-model="formData.nilai" 
                                min="0" 
                                max="100" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            >
                        </div>
                        
                        <div class="flex space-x-3 pt-4">
                            <button 
                                type="button" 
                                @click="showAddModal = false" 
                                class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
                            >
                                Batal
                            </button>
                            <button 
                                type="submit" 
                                class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
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