<!-- resources/js/Pages/Admin/Students/Index.vue -->
<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

defineOptions({
    layout: AdminLayout
});

const siswaData = ref([
    { id: 1, nama: 'Andi', kelas: '7A', jumlah_nilai: 2, rata_rata: 75 },
    { id: 2, nama: 'Budi', kelas: '7A', jumlah_nilai: 2, rata_rata: 67.5 },
    { id: 3, nama: 'Citra', kelas: '7B', jumlah_nilai: 2, rata_rata: 87.5 }
]);

const showAddSiswaModal = ref(false);
</script>

<template>
    <div>
        <Head title="Data Siswa" />
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Data Siswa</h1>
            <button 
                @click="showAddSiswaModal = true" 
                class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition"
            >
                <i class="fas fa-plus mr-2"></i>Tambah Siswa
            </button>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Jumlah Nilai</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Rata-rata</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr 
                            v-for="(siswa, index) in siswaData" 
                            :key="siswa.id"
                            class="hover:bg-gray-50 transition"
                        >
                            <td class="px-6 py-4 text-sm text-gray-800">{{ index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ siswa.nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ siswa.kelas }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ siswa.jumlah_nilai }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                    {{ siswa.rata_rata }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>